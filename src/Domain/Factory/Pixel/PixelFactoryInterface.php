<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Pixel;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;

interface PixelFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(
        int $x,
        int $y,
        string $rgbHex,
        ?int $deviation = null,
    ): Pixel;
}
