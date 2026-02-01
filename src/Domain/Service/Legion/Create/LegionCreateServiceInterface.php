<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface LegionCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        string $title,
        ?string $extTitle,
        ?int $payDayOfMonth,
    ): Legion;
}
