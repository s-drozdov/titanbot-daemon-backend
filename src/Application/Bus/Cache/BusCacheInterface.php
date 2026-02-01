<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Bus\Cache;

use RuntimeException;
use Titanbot\Daemon\Application\Bus\CqrsResultInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;

interface BusCacheInterface
{
    /**
     * @param class-string|null $resultFqcn
     * 
     * @throws RuntimeException
     */
    public function get(CqrsElementInterface $element, ?string $resultFqcn = null): ?CqrsResultInterface;

    /**
     * @throws RuntimeException
     */
    public function set(CqrsElementInterface $element, CqrsResultInterface $result, ?int $expireSeconds = null): void;

    /**
     * @throws RuntimeException
     */
    public function clear(): void;
}
