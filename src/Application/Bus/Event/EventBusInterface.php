<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus\Event;

use Exception;
use Titanbot\Daemon\Domain\Event\EventInterface;
use Titanbot\Daemon\Application\Bus\BusInterface;

interface EventBusInterface extends BusInterface
{   
    /**
     * @param EventInterface[] $eventList
     * 
     * @throws Exception
     */
    public function dispatch(...$eventList): void;
}
