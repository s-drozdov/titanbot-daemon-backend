<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\DaemonToken\Create\DaemonTokenCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<DaemonTokenCreateCommand,DaemonTokenCreateCommandResult>
 */
final readonly class DaemonTokenCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DaemonTokenCreateServiceInterface $daemonTokenCreateService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DaemonTokenCreateCommandResult
    {
        $entity = $this->daemonTokenCreateService->perform($command->token);

        return new DaemonTokenCreateCommandResult(uuid: $entity->getUuid());
    }
}
