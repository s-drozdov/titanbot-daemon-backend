<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity;

use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\Event\EventInterface;

interface AggregateInterface extends EntityInterface
{
    /**
     * @return EventInterface[]
     */
    public function pullEvents(): array;

    public function raise(EventInterface $event): void;

    public function isEventsEmpty(): bool;
}
