<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Legion\Update\LegionUpdateParamsDto;

interface LegionUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(LegionUpdateParamsDto $paramsDto): Legion;
}