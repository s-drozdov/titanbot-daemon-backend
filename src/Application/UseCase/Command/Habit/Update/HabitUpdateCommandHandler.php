<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Update;

use Override;
use Titanbot\Daemon\Application\Dto\Mapper\HabitMapper;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Update\HabitUpdateParamsDto;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Habit\Update\HabitUpdateServiceInterface;
use Titanbot\Daemon\Application\Service\Pixel\GetList\PixelListGetServiceInterface;

/**
 * @implements CommandHandlerInterface<HabitUpdateCommand,HabitUpdateCommandResult>
 */
final readonly class HabitUpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HabitUpdateServiceInterface $habitUpdateService,
        private PixelListGetServiceInterface $pixelListGetService,

        /** @var HabitMapper $habitMapper */
        private HabitMapper $habitMapper,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): HabitUpdateCommandResult
    {
        $paramsDto = new HabitUpdateParamsDto(
            uuid: $command->uuid,
            action: $command->action,
            pixelList: $this->pixelListGetService->perform($command->pixel_list),
            accountLogicalId: $command->account_logical_id,
            priority: $command->priority,
            triggerOcr: $command->trigger_ocr,
            triggerShell: $command->trigger_shell,
            logTemplate: $command->log_template,
            postTimeoutMs: $command->post_timeout_ms,
            comment: $command->comment,
            sequence: $command->sequence,
            context: $command->context,
            isInterruption: $command->is_interruption,
            isActive: $command->is_active,
        );

        $entity = $this->habitUpdateService->perform($paramsDto);

        $this->eventBus->dispatch(...$entity->pullEvents());
        
        return new HabitUpdateCommandResult(
            habit: $this->habitMapper->mapDomainObjectToDto($entity),
        );
    }
}
