<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Legion;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;

interface LegionFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(
        string $title,
        ?string $extTitle,
        ?int $payDayOfMonth,
    ): Legion;
}
