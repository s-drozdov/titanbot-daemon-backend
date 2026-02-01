<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\Collection;

use IteratorAggregate;

/**
 * @template T
 * @extends ArrayableInterface<array-key, T>
 * @extends IteratorAggregate<array-key, T>
 */
interface ListInterface extends ArrayableInterface, IteratorAggregate, InnerTypeInterface
{
    public const string PROPERTY_VALUE = 'value';
    public const string PROPERTY_INNER_TYPE = 'innerType';
}