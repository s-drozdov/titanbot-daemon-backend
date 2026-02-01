<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Bus;

use Override;
use Titanbot\Daemon\Domain\Event\EventInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;

final class EventBus implements EventBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->messageBus = $eventBus;
    }
    
    /**
     * @inheritdoc
     * @param EventInterface[] $eventList
     */
    #[Override]
    public function dispatch(...$eventList): void
    {
        /** @var EventInterface $event */
        foreach ($eventList as $event) {
            $this->messageBus->dispatch($event);
        }
    }
}
