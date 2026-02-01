<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Account\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Application\Dto\AccountDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\AccountDto as AccountDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class AccountIndexQueryResult
{
    /**
     * @var MapInterface<string,AccountDto> $uuid_to_account_map
     */
    #[OA\Property(
        type: PhpType::object->value,
        additionalProperties: new OA\AdditionalProperties(
            ref: new Model(type: AccountDtoSchema::class),
        ),
    )]
    public MapInterface $uuid_to_account_map;
}
