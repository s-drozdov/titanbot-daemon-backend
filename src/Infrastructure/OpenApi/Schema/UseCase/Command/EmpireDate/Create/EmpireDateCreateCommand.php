<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\EmpireDate\Create;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Titanbot\Daemon\Library\Enum\PhpType;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class EmpireDateCreateCommand
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public DateTimeImmutable $date;
}
