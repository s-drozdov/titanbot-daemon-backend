<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Shape\Create\ShapeCreateParamsDto;

interface ShapeCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(ShapeCreateParamsDto $paramsDto): Shape;
}
