<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Helper\Uuid;

use Override;

use Ramsey\Uuid\Uuid;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Infrastructure\Adapter\RamseyAdapter;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class RamseyUuidHelper implements UuidHelperInterface
{
    #[Override]
    public function create(): UuidInterface
    {
        return new RamseyAdapter(
            Uuid::uuid4(),
        );
    }

    #[Override]
    public function fromString(string $source): UuidInterface
    {
        return new RamseyAdapter(
            Uuid::fromString($source),
        );
    }

    #[Override]
    public function fromBytes(string $source): UuidInterface
    {
        return new RamseyAdapter(
            Uuid::fromBytes($source),
        );
    }

    #[Override]
    public function isValid(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }
}
