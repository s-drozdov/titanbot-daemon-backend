<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Delete;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface PixelDeleteServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Pixel;
}
