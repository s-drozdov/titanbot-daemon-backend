<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Legion\Delete;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Legion\Delete\LegionDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<LegionDeleteCommand,LegionDeleteCommandResult>
 */
final readonly class LegionDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LegionDeleteServiceInterface $legionDeleteService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): LegionDeleteCommandResult
    {
        $this->legionDeleteService->perform($command->uuid);

        return new LegionDeleteCommandResult();
    }
}
