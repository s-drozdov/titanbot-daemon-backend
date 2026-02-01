<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Create;

use Override;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Index\PixelIndexServiceInterface;
use Titanbot\Daemon\Domain\Service\Habit\Create\HabitCreateServiceInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Create\PixelCreateServiceInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

/**
 * @implements CommandHandlerInterface<HabitCreateCommand,HabitCreateCommandResult>
 */
final readonly class HabitCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HabitCreateServiceInterface $habitCreateService,
        private PixelCreateServiceInterface $pixelCreateService,
        private PixelIndexServiceInterface $pixelIndexService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): HabitCreateCommandResult
    {
        $entity = $this->habitCreateService->perform(
            action: $command->action,
            pixelList: $this->getPixelList($command),
            accountLogicalId: $command->account_logical_id,
            priority: $command->priority,
            triggerOcr: $command->trigger_ocr,
            triggerShell: $command->trigger_shell,
            isActive: $command->is_active,
        );

        $this->eventBus->dispatch(...$entity->pullEvents());

        return new HabitCreateCommandResult(uuid: $entity->getUuid());
    }

    /**
     * @return ListInterface<Pixel>
     */
    private function getPixelList(HabitCreateCommand $command): ?ListInterface
    {
        if ($command->pixel_list === null) {
            return null;
        }

        return new Collection(
            value: array_map(
                fn (PixelRequestDto $pixelRequestDto) => $this->getPixel($pixelRequestDto),
                $command->pixel_list->toArray(),
            ),
            innerType: Pixel::class,
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getPixel(PixelRequestDto $pixelRequestDto): Pixel
    {
        $paginationResult = $this->pixelIndexService->perform($pixelRequestDto->x, $pixelRequestDto->y, $pixelRequestDto->rgb_hex, $pixelRequestDto->deviation);
        $pixelList = $paginationResult->items->toArray();

        if (!empty($pixelList)) {
            return current($pixelList);
        }

        return $this->pixelCreateService->perform(
            $pixelRequestDto->x, 
            $pixelRequestDto->y, 
            $pixelRequestDto->rgb_hex, 
            $pixelRequestDto->deviation,
        );
    }
}
