<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Shape\GetList;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Application\Dto\ShapeRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;

interface ShapeListGetServiceInterface
{
    /**
     * @param ListInterface<ShapeRequestDto>|null $shapeList
     *
     * @return ListInterface<Shape>|null
     * @throws InvalidArgumentException
     */
    public function perform(?ListInterface $shapeList): ?ListInterface;
}
