<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Aggregation;

use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

/**
 * @template TGroupField of mixed
 * @template TDto of DtoInterface
 */
final readonly class DtoGroupAggregation
{
    public function __construct(

        /** @var TGroupField $group */
        public mixed $group,

        /** @var ListInterface<TDto> $items */
        public ListInterface $items,
    ) {
        /*_*/
    }
}
