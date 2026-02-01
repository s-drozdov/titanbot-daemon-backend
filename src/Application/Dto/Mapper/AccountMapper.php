<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\AccountDto;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<Account,AccountDto>
 */
readonly class AccountMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): AccountDto
    {
        return new AccountDto(
            uuid: $object->getUuid(),
            logical_id: $object->getLogicalId(),
            first_name: $object->getFirstName(),
            last_name: $object->getLastName(),
            birth_date: $object->getBirthDate(),
            gender: $object->getGender(),
            google_login: $object->getGoogleLogin(),
            google_password: $object->getGooglePassword(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Account
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Account::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return AccountDto::class;
    }
}
