<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Persistence\Doctrine\Type;

use InvalidArgumentException;
use Override;
use Doctrine\DBAL\Types\StringType;
use Titanbot\Daemon\Domain\Enum\Gender;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class GenderType extends StringType
{
    private const string ERROR_INVALID_TYPE = 'Invalid type';

    public const NAME = 'gender_enum';

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Gender
    {
        if ($value !== null && !is_string($value)) {
            throw new InvalidArgumentException(self::ERROR_INVALID_TYPE);
        }

        return $value === null ? null : Gender::tryFrom($value);
    }

    #[Override]
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (!$value instanceof Gender) {
            return null;
        }

        return $value->value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
