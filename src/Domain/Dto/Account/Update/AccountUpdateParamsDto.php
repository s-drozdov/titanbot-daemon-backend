<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Account\Update;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class AccountUpdateParamsDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?string $firstName,
        public ?string $lastName,
        public ?DateTimeImmutable $birthDate,
        public ?Gender $gender,
        public ?string $googleLogin,
        public ?string $googlePassword,
        public ?bool $isEmpireSleeping,
    ) {
        /*_*/
    }
}
