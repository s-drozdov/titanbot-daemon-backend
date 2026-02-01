<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Bus\Processor;

use Titanbot\Daemon\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

/**
 * @template TElement of CommandInterface
 * @template TResult of CommandResultInterface
 * 
 * @extends AbstractCommandBusProcessor<TElement, TResult>
 */
final readonly class CommandBusCommandProcessor extends AbstractCommandBusProcessor
{
    /** 
     * @param CommandBusInterface<TElement, TResult> $commandBus
     */
    public function __construct(CommandBusInterface $commandBus,
                                SerializerInterface $serializer)
    {
        parent::__construct($commandBus, $serializer);
    }
}
