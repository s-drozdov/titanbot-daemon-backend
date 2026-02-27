<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Delete;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface ShapeDeleteServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Shape;
}
