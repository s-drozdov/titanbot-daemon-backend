<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Delete;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Service\DaemonToken\Delete\DaemonTokenDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<DaemonTokenDeleteCommand,DaemonTokenDeleteCommandResult>
 */
final readonly class DaemonTokenDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DaemonTokenDeleteServiceInterface $daemonTokenDeleteService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DaemonTokenDeleteCommandResult
    {
        $this->daemonTokenDeleteService->perform($command->uuid);

        return new DaemonTokenDeleteCommandResult();
    }
}
