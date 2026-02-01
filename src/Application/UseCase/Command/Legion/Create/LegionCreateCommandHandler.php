<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Legion\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Legion\Create\LegionCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<LegionCreateCommand,LegionCreateCommandResult>
 */
final readonly class LegionCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LegionCreateServiceInterface $legionCreateService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): LegionCreateCommandResult
    {
        $entity = $this->legionCreateService->perform(
            title: $command->title,
            extTitle: $command->ext_title,
            payDayOfMonth: $command->pay_day_of_month,
        );

        return new LegionCreateCommandResult(uuid: $entity->getUuid());
    }
}
