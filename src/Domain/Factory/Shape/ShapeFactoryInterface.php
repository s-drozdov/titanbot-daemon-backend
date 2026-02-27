<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Shape;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Dto\Shape\Create\ShapeCreateParamsDto;

interface ShapeFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(ShapeCreateParamsDto $paramsDto): Shape;
}
