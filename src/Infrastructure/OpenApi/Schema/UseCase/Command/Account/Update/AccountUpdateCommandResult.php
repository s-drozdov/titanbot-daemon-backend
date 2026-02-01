<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Update;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\AccountDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\AccountDto as AccountDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class AccountUpdateCommandResult
{
    #[OA\Property(
        ref: new Model(type: AccountDtoSchema::class)
    )]
    public AccountDto $device;
}
