<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\Create;

use DateTimeImmutable;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface EmpireDateCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        DateTimeImmutable $date,
    ): EmpireDate;
}
