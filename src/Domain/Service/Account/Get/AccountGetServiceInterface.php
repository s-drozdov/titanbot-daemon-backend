<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Get;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;

interface AccountGetServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Account;
}
