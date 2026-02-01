<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus\Command;

use Titanbot\Daemon\Application\Bus\CqrsHandlerInterface;

/**
 * @template TElement of CommandInterface
 * @template TResult of CommandResultInterface
 * 
 * @extends CqrsHandlerInterface<TElement, TResult>
 */
interface CommandHandlerInterface extends CqrsHandlerInterface
{
    /*_*/
}
