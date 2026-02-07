<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Pixel;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Dto\Pixel\Create\PixelCreateParamsDto;

interface PixelFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(PixelCreateParamsDto $paramsDto): Pixel;
}
