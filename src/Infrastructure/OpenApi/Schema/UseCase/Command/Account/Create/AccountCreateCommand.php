<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Create;

use DateTimeImmutable;
use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class AccountCreateCommand
{
    public int $logical_id;
    
    public string $first_name;
    
    public string $last_name;
    
    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public DateTimeImmutable $birth_date;
    
    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public Gender $gender;
    
    public string $google_login;
    
    public string $google_password;
    
}
