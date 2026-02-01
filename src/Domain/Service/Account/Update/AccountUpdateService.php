<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Update;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;

final readonly class AccountUpdateService implements AccountUpdateServiceInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        UuidInterface $uuid,
        ?string $firstName,
        ?string $lastName,
        ?DateTimeImmutable $birthDate,
        ?Gender $gender,
        ?string $googleLogin,
        ?string $googlePassword,
    ): Account {
        $entity = $this->accountRepository->getByUuid($uuid);

        if ($firstName !== null) {
            $entity->setFirstName($firstName);
        }

        if ($lastName !== null) {
            $entity->setLastName($lastName);
        }

        if ($birthDate !== null) {
            $entity->setBirthDate($birthDate);
        }

        if ($gender !== null) {
            $entity->setGender($gender);
        }

        if ($googleLogin !== null) {
            $entity->setGoogleLogin($googleLogin);
        }

        if ($googlePassword !== null) {
            $entity->setGooglePassword($googlePassword);
        }

        $this->accountRepository->update($entity);

        return $entity;
    }
}
