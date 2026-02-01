<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Account\Create;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class AccountCreateCommand implements CommandInterface
{
    public function __construct(
        public int $logical_id,
        public string $first_name,
        public string $last_name,
        public DateTimeImmutable $birth_date,
        public Gender $gender,
        public string $google_login,
        public string $google_password,
    ) {
        /*_*/
    }
}
