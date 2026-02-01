<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Delete;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\EmpireDate\Delete\EmpireDateDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<EmpireDateDeleteCommand,EmpireDateDeleteCommandResult>
 */
final readonly class EmpireDateDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmpireDateDeleteServiceInterface $empireDateDeleteService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): EmpireDateDeleteCommandResult
    {
        $this->empireDateDeleteService->perform($command->uuid);

        return new EmpireDateDeleteCommandResult();
    }
}
