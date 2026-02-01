<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Persistence\Doctrine\Type;

use Override;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Infrastructure\Adapter\RamseyAdapter;
use Ramsey\Uuid\Doctrine\UuidBinaryType as RamseyUuidBinaryType;

final class UuidBinaryType extends RamseyUuidBinaryType
{
    #[Override]
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?UuidInterface
    {
        $value = parent::convertToPHPValue($value, $platform);

        if ($value === null) {
            return null;
        }

        return new RamseyAdapter($value);
    }
}
