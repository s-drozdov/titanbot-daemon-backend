<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\Collection;

use Traversable;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends Traversable<TKey, TValue>
 */
interface ArrayableInterface extends Traversable
{   
    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array;
}
