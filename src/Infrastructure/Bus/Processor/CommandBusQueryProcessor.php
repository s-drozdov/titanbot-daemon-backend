<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Bus\Processor;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

/**
 * @template TElement of QueryInterface
 * @template TResult of QueryResultInterface
 * 
 * @extends AbstractCommandBusProcessor<TElement, TResult>
 */
final readonly class CommandBusQueryProcessor extends AbstractCommandBusProcessor
{
    /** 
     * @param QueryBusInterface<TElement, TResult> $queryBus
     */
    public function __construct(QueryBusInterface $queryBus,
                                SerializerInterface $serializer)
    {
        parent::__construct($queryBus, $serializer);
    }
}
