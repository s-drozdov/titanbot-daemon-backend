<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Create\HabitCreateParamsDto;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Habit\Create\HabitCreateServiceInterface;
use Titanbot\Daemon\Application\Service\Pixel\GetList\PixelListGetServiceInterface;
use Titanbot\Daemon\Application\Service\Shape\GetList\ShapeListGetServiceInterface;

/**
 * @implements CommandHandlerInterface<HabitCreateCommand,HabitCreateCommandResult>
 */
final readonly class HabitCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HabitCreateServiceInterface $habitCreateService,
        private PixelListGetServiceInterface $pixelListGetService,
        private ShapeListGetServiceInterface $shapeListGetService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): HabitCreateCommandResult
    {
        $paramsDto = new HabitCreateParamsDto(
            action: $command->action,
            pixelList: $this->pixelListGetService->perform($command->pixel_list),
            shapeList: $this->shapeListGetService->perform($command->shape_list),
            accountLogicalId: $command->account_logical_id,
            priority: $command->priority,
            triggerShell: $command->trigger_shell,
            logTemplate: $command->log_template,
            postTimeoutMs: $command->post_timeout_ms,
            comment: $command->comment,
            sequence: $command->sequence,
            context: $command->context,
            isInterruption: $command->is_interruption,
            isActive: $command->is_active,
        );

        $entity = $this->habitCreateService->perform($paramsDto);

        $this->eventBus->dispatch(...$entity->pullEvents());

        return new HabitCreateCommandResult(uuid: $entity->getUuid());
    }
}
