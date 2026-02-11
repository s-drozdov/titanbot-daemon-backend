<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Account\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Dto\Account\Create\AccountCreateParamsDto;
use Titanbot\Daemon\Domain\Service\Account\Create\AccountCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<AccountCreateCommand,AccountCreateCommandResult>
 */
final readonly class AccountCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AccountCreateServiceInterface $accountCreateService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): AccountCreateCommandResult
    {
        $paramsDto = new AccountCreateParamsDto(
            logicalId: $command->logical_id,
            firstName: $command->first_name,
            lastName: $command->last_name,
            birthDate: $command->birth_date,
            gender: $command->gender,
            googleLogin: $command->google_login,
            googlePassword: $command->google_password,
            isEmpireSleeping: $command->is_empire_sleeping,
        );

        $entity = $this->accountCreateService->perform($paramsDto);

        return new AccountCreateCommandResult(uuid: $entity->getUuid());
    }
}
