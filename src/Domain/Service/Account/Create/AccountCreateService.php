<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;
use Titanbot\Daemon\Domain\Factory\Account\AccountFactoryInterface;
use Titanbot\Daemon\Domain\Dto\Account\Create\AccountCreateParamsDto;

final readonly class AccountCreateService implements AccountCreateServiceInterface
{
    public function __construct(
        private AccountFactoryInterface $accountFactory,
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(AccountCreateParamsDto $paramsDto): Account {
        $entity = $this->accountFactory->create($paramsDto);
        
        $this->accountRepository->save($entity);

        return $entity;
    }
}
