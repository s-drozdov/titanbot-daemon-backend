<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Account\Create;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Dto\DtoInterface;

final readonly class AccountCreateParamsDto implements DtoInterface
{
    public function __construct(
        public int $logicalId,
        public string $firstName,
        public string $lastName,
        public DateTimeImmutable $birthDate,
        public Gender $gender,
        public string $googleLogin,
        public string $googlePassword,
        public bool $isEmpireSleeping,
    ) {
        /*_*/
    }
}
