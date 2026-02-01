<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class AccountDto
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public int $logical_id;

    public string $first_name;

    public string $last_name;

    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public DateTimeImmutable $birth_date;

    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public Gender $gender;
    
    public string $google_login;

    public string $google_password;
}
