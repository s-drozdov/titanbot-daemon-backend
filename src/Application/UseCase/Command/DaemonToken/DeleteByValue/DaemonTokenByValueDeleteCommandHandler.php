<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\DaemonToken\DeleteByValue;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\DaemonToken\DeleteByValue\DaemonTokenByValueDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<DaemonTokenByValueDeleteCommand,DaemonTokenByValueDeleteCommandResult>
 */
final readonly class DaemonTokenByValueDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DaemonTokenByValueDeleteServiceInterface $daemonTokenByValueDeleteService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DaemonTokenByValueDeleteCommandResult
    {
        $this->daemonTokenByValueDeleteService->perform($command->token);

        return new DaemonTokenByValueDeleteCommandResult();
    }
}
