<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Helper\Uuid;

use Titanbot\Daemon\Domain\Helper\HelperInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface UuidHelperInterface extends HelperInterface
{
    public function create(): UuidInterface;

    public function fromString(string $source): UuidInterface;

    public function fromBytes(string $source): UuidInterface;

    public function isValid(string $uuid): bool;
}
