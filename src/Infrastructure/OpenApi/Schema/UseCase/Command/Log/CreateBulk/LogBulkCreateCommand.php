<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Log\CreateBulk;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\LogDto;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\LogDto as LogDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class LogBulkCreateCommand
{
    /**
     * @var ListInterface<LogDto> $log_dto_list
     */
    #[OA\Property(
        type: OpenApiType::array->value,
        items: new OA\Items(
            ref: new Model(type: LogDtoSchema::class),
        ),
    )]
    public ListInterface $log_dto_list;
}
