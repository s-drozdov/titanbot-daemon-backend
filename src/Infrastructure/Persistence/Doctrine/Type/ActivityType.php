<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Persistence\Doctrine\Type;

use InvalidArgumentException;
use Override;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Titanbot\Daemon\Domain\Enum\ActivityType as ActivityTypeEnum;

final class ActivityType extends StringType
{
    private const string ERROR_INVALID_TYPE = 'Invalid type';

    public const NAME = 'activity_type_enum';

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ActivityTypeEnum
    {
        if ($value !== null && !is_string($value)) {
            throw new InvalidArgumentException(self::ERROR_INVALID_TYPE);
        }

        return $value === null ? null : ActivityTypeEnum::tryFrom($value);
    }

    #[Override]
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (!$value instanceof ActivityTypeEnum) {
            return null;
        }

        return $value->value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
