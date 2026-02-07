<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Index;

use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Dto\Pixel\Index\PixelIndexParamsDto;

interface PixelIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<Pixel>
     */
    public function perform(PixelIndexParamsDto $paramsDto): PaginationResult;
}
