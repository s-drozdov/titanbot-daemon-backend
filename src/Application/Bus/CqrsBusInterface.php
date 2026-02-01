<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus;

use Titanbot\Daemon\Application\Bus\CqrsResultInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Throwable;

/**
 * @template TElement of CqrsElementInterface
 * @template TResult of CqrsResultInterface
 */
interface CqrsBusInterface extends BusInterface
{
    /**
     * @param TElement $element
     * 
     * @return TResult
     * @throws Throwable
     */
    public function execute($element): mixed;
}
