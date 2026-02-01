<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Legion\Update;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class LegionUpdateCommand
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public ?string $title;

    public ?string $ext_title;

    public ?int $pay_day_of_month;
}
