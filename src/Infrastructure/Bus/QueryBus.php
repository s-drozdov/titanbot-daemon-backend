<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Bus;

use Override;
use Symfony\Component\Messenger\HandleTrait;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

/**
 * @implements QueryBusInterface<QueryInterface, QueryResultInterface>
 */
final class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }
    
    #[Override]
    public function execute($element): QueryResultInterface
    {
        try {
            /** @var QueryResultInterface $result */
            $result = $this->handle($element);

            return $result;
        } catch (HandlerFailedException $exception) {
            if (is_null($exception->getPrevious())) {
                throw $exception;
            }

            throw $exception->getPrevious();
        }
    }
}
