<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity;

abstract class Aggregate implements AggregateInterface
{
    use Eventable;
}
