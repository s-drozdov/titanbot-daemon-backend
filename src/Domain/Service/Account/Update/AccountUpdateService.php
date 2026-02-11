<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Update;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Account\Update\AccountUpdateParamsDto;

final readonly class AccountUpdateService implements AccountUpdateServiceInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(AccountUpdateParamsDto $paramsDto): Account {
        $entity = $this->accountRepository->getByUuid($paramsDto->uuid);

        if ($paramsDto->firstName !== null) {
            $entity->setFirstName($paramsDto->firstName);
        }

        if ($paramsDto->lastName !== null) {
            $entity->setLastName($paramsDto->lastName);
        }

        if ($paramsDto->birthDate !== null) {
            $entity->setBirthDate($paramsDto->birthDate);
        }

        if ($paramsDto->gender !== null) {
            $entity->setGender($paramsDto->gender);
        }

        if ($paramsDto->googleLogin !== null) {
            $entity->setGoogleLogin($paramsDto->googleLogin);
        }

        if ($paramsDto->googlePassword !== null) {
            $entity->setGooglePassword($paramsDto->googlePassword);
        }

        if ($paramsDto->isEmpireSleeping !== null) {
            $entity->setIsEmpireSleeping($paramsDto->isEmpireSleeping);
        }

        $this->accountRepository->update($entity);

        return $entity;
    }
}
