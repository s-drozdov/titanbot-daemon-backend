<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Pixel\Create\PixelCreateParamsDto;

interface PixelCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(PixelCreateParamsDto $paramsDto): Pixel;
}
