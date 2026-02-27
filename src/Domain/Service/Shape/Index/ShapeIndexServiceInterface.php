<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Index;

use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Dto\Shape\Index\ShapeIndexParamsDto;

interface ShapeIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<Shape>
     */
    public function perform(ShapeIndexParamsDto $paramsDto): PaginationResult;
}
