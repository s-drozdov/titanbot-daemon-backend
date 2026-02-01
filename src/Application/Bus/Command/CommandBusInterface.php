<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus\Command;

use Titanbot\Daemon\Application\Bus\CqrsBusInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

/**
 * @template TElement of CommandInterface
 * @template TResult of CommandResultInterface
 * 
 * @extends CqrsBusInterface<TElement, TResult>
 */
interface CommandBusInterface extends CqrsBusInterface
{
    /*_*/
}
