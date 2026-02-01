<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Habit\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Application\Dto\HabitDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\HabitDto as HabitDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class HabitIndexQueryResult
{
    /**
     * @var MapInterface<string,HabitDto> $uuid_to_habit_map
     */
    #[OA\Property(
        type: PhpType::object->value,
        additionalProperties: new OA\AdditionalProperties(
            ref: new Model(type: HabitDtoSchema::class),
        ),
    )]
    public MapInterface $uuid_to_habit_map;
}
