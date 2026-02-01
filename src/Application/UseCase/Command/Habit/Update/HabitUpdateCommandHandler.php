<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Update;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Dto\Mapper\HabitMapper;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Index\PixelIndexServiceInterface;
use Titanbot\Daemon\Domain\Service\Habit\Update\HabitUpdateServiceInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Create\PixelCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<HabitUpdateCommand,HabitUpdateCommandResult>
 */
final readonly class HabitUpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HabitUpdateServiceInterface $habitUpdateService,
        private PixelIndexServiceInterface $pixelIndexService,
        private PixelCreateServiceInterface $pixelCreateService,

        /** @var HabitMapper $habitMapper */
        private HabitMapper $habitMapper,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): HabitUpdateCommandResult
    {
        $entity = $this->habitUpdateService->perform(
            uuid: $command->uuid,
            action: $command->action,
            pixelList: $this->getPixelList($command),
            accountLogicalId: $command->account_logical_id,
            priority: $command->priority,
            triggerOcr: $command->trigger_ocr,
            triggerShell: $command->trigger_shell,
            isActive: $command->is_active,
        );

        $this->eventBus->dispatch(...$entity->pullEvents());
        
        return new HabitUpdateCommandResult(
            habit: $this->habitMapper->mapDomainObjectToDto($entity),
        );
    }

    /**
     * @return ListInterface<Pixel>|null
     */
    private function getPixelList(HabitUpdateCommand $command): ?ListInterface
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

    private function getPixel(PixelRequestDto $pixelRequestDto): Pixel
    {
        $paginationResult = $this->pixelIndexService->perform(
            $pixelRequestDto->x, 
            $pixelRequestDto->y, 
            $pixelRequestDto->rgb_hex, 
            $pixelRequestDto->deviation, 
        );

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
