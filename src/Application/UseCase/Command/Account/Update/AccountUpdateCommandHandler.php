<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Account\Update;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\AccountMapper;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Account\Update\AccountUpdateServiceInterface;

/**
 * @implements CommandHandlerInterface<AccountUpdateCommand,AccountUpdateCommandResult>
 */
final readonly class AccountUpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountUpdateServiceInterface $accountUpdateService,

        /** @var AccountMapper $accountMapper */
        private AccountMapper $accountMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AccountUpdateCommandResult
    {
        $entity = $this->accountUpdateService->perform(
            uuid: $command->uuid,
            firstName: $command->first_name,
            lastName: $command->last_name,
            birthDate: $command->birth_date,
            gender: $command->gender,
            googleLogin: $command->google_login,
            googlePassword: $command->google_password,
        );

        return new AccountUpdateCommandResult(
            account: $this->accountMapper->mapDomainObjectToDto($entity),
        );
    }
}
