<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Account\Update;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class AccountUpdateCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?string $first_name,
        public ?string $last_name,
        public ?DateTimeImmutable $birth_date,
        public ?Gender $gender,
        public ?string $google_login,
        public ?string $google_password,
        public ?bool $is_empire_sleeping,
    ) {
        /*_*/
    }
}
