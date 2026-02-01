<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Account;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class AccountFactory implements AccountFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(
        int $logicalId,
        string $firstName,
        string $lastName,
        DateTimeImmutable $birthDate,
        Gender $gender,
        string $googleLogin,
        string $googlePassword,
    ): Account {
        return new Account(
            uuid: $this->uuidHelper->create(),
            logicalId: $logicalId,
            firstName: $firstName,
            lastName: $lastName,
            birthDate: $birthDate,
            gender: $gender,
            googleLogin: $googleLogin,
            googlePassword: $googlePassword,
        );
    }
}
