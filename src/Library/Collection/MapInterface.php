<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\Collection;

use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends ArrayableInterface<TKey, TValue>
 * @extends IteratorAggregate<TKey, TValue>
 */
interface MapInterface extends ArrayableInterface, IteratorAggregate, InnerTypeInterface
{
    public const string PROPERTY_VALUE = 'value';
    public const string PROPERTY_INNER_TYPE = 'innerType';
}