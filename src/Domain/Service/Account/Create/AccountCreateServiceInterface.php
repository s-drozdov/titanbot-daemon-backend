<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Create;

use DateTimeImmutable;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface AccountCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        int $logicalId,
        string $firstName,
        string $lastName,
        DateTimeImmutable $birthDate,
        Gender $gender,
        string $googleLogin,
        string $googlePassword,
    ): Account;
}
