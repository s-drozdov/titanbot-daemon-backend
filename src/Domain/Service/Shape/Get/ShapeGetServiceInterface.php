<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Get;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface ShapeGetServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Shape;
}
