<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Habit\Get;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\HabitDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\HabitDto as HabitDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class HabitGetQueryResult
{
    #[OA\Property(
        ref: new Model(type: HabitDtoSchema::class)
    )]
    public HabitDto $habit;
}
