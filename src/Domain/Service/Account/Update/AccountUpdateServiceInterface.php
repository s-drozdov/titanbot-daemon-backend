<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Update;

use DateTimeImmutable;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;

interface AccountUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        UuidInterface $uuid,
        ?string $firstName,
        ?string $lastName,
        ?DateTimeImmutable $birthDate,
        ?Gender $gender,
        ?string $googleLogin,
        ?string $googlePassword,
    ): Account;
}
