<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity;

use Titanbot\Daemon\Domain\Event\EventInterface;

trait Eventable
{
    /**
     * @var EventInterface[]
     */
    private array $events = [];

    /**
     * @return EventInterface[]
     */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    public function isEventsEmpty(): bool
    {
        return empty($this->events);
    }

    public function raise(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}
