<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus\Query;

use Titanbot\Daemon\Application\Bus\CqrsHandlerInterface;

/**
 * @template TElement of QueryInterface
 * @template TResult of QueryResultInterface
 * 
 * @extends CqrsHandlerInterface<TElement, TResult>
 */
interface QueryHandlerInterface extends CqrsHandlerInterface
{
    /*_*/
}
