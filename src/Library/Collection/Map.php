<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\Collection;

use Override;
use Titanbot\Daemon\Library\Collection\Arrayable;

/**
 * @template TKey of array-key
 * @template TValue of mixed
 * 
 * @implements MapInterface<TKey, TValue>
 */
final readonly class Map implements MapInterface
{
    /** @use Arrayable<TKey, TValue> */
    use Arrayable;

    public function __construct(
        /** @var array<TKey, TValue> */
        private array $value,

        private ?string $innerType,
    ) {
        /*_*/
    }

    /**
     * @return array<TKey, TValue>
     */
    #[Override]
    public function toArray(): array
    {
        return $this->value;
    }

    #[Override]
    public function getInnerType(): ?string
    {
        return $this->innerType;
    }
}
