<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;

interface LegionUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        UuidInterface $uuid,
        ?string $title,
        ?string $extTitle,
        ?int $payDayOfMonth,
    ): Legion;
}