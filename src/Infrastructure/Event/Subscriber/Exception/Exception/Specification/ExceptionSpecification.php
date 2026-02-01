<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Event\Subscriber\Exception\Exception\Specification;

use Throwable;
use Titanbot\Daemon\Library\Specification\SpecificationInterface;

final class ExceptionSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(?Throwable $exception, string $type): bool
    {
        if (is_null($exception)) {
            return false;
        }

        if ($exception instanceof $type) {
            return true;
        }

        return false;
    }
}
