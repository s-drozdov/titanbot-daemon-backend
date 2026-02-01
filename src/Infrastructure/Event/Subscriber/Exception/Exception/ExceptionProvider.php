<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Event\Subscriber\Exception\Exception;

use Throwable;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Titanbot\Daemon\Infrastructure\Event\Subscriber\Exception\Exception\Specification\ExceptionSpecification;

final class ExceptionProvider
{
    public function __construct(
        private ExceptionSpecification $exceptionSpecification,
    ) {
        /*_*/
    }

    public function get(ExceptionEvent $event, string $type): ?Throwable
    {
        $exceptionList = [
            $event->getThrowable(), 
            $event->getThrowable()->getPrevious(),
            $event->getThrowable()->getPrevious()?->getPrevious(),
        ];

        foreach ($exceptionList as $exception) {
            if (!$this->exceptionSpecification->isSatisfiedBy($exception, $type)) {
                continue;
            }

            return $exception;
        }

        return null;
    }
}
