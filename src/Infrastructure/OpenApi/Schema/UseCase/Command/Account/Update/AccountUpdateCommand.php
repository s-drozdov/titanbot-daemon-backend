<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Update;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class AccountUpdateCommand
{
    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public ?string $first_name;

    public ?string $last_name;

    #[OA\Property(type: OpenApiType::string->value, nullable: true)]
    public ?DateTimeImmutable $birth_date;

    #[OA\Property(type: OpenApiType::string->value, nullable: true)]
    public ?Gender $gender;

    public ?string $google_login;

    public ?string $google_password;

    public ?bool $is_empire_sleeping;

}
