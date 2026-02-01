<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\EmpireDate;

use DateTimeImmutable;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;

interface EmpireDateFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(
        DateTimeImmutable $date,
    ): EmpireDate;
}
