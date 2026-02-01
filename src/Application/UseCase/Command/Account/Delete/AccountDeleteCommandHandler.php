<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Account\Delete;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Account\Delete\AccountDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<AccountDeleteCommand,AccountDeleteCommandResult>
 */
final readonly class AccountDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountDeleteServiceInterface $accountDeleteService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AccountDeleteCommandResult
    {
        $this->accountDeleteService->perform($command->uuid);

        return new AccountDeleteCommandResult();
    }
}
