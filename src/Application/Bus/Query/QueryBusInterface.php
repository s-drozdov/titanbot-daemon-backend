<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus\Query;

use Titanbot\Daemon\Application\Bus\CqrsBusInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

/**
 * @template TElement of QueryInterface
 * @template TResult of QueryResultInterface
 * 
 * @extends CqrsBusInterface<TElement, TResult>
 */
interface QueryBusInterface extends CqrsBusInterface
{
    /*_*/
}
