<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Account;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Dto\Account\Create\AccountCreateParamsDto;

final readonly class AccountFactory implements AccountFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(AccountCreateParamsDto $paramsDto): Account {
        return new Account(
            uuid: $this->uuidHelper->create(),
            logicalId: $paramsDto->logicalId,
            firstName: $paramsDto->firstName,
            lastName: $paramsDto->lastName,
            birthDate: $paramsDto->birthDate->setTime(0, 0, 0),
            gender: $paramsDto->gender,
            googleLogin: $paramsDto->googleLogin,
            googlePassword: $paramsDto->googlePassword,
            isEmpireSleeping: $paramsDto->isEmpireSleeping,
        );
    }
}
