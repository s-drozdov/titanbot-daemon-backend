<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\EmpireDate\Get;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\EmpireDateDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\EmpireDateDto as EmpireDateDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class EmpireDateGetQueryResult
{
    #[OA\Property(
        ref: new Model(type: EmpireDateDtoSchema::class)
    )]
    public EmpireDateDto $empire_date;
}
