<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Account;

use DateTimeImmutable;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;

interface AccountFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(
        int $logicalId,
        string $firstName,
        string $lastName,
        DateTimeImmutable $birthDate,
        Gender $gender,
        string $googleLogin,
        string $googlePassword,
    ): Account;
}
