<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Log\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Application\Dto\LogDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\LogDto as LogDtoSchema;
use Titanbot\Daemon\Library\Collection\ListInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class LogIndexQueryResult
{
    /**
     * @var ListInterface<LogDto> $log_list
     */
    #[OA\Property(
        type: PhpType::array->value,
        items: new OA\Items(ref: new Model(type: LogDtoSchema::class))
    )]
    public ListInterface $log_list;
}
