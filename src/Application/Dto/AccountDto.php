<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class AccountDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public int $logical_id,
        public string $first_name,
        public string $last_name,
        public DateTimeImmutable $birth_date,
        public Gender $gender,
        public string $google_login,
        public string $google_password,
        public bool $is_empire_sleeping,
    ) {
        /*_*/
    }
}
