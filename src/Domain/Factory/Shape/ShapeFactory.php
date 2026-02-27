<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Shape;

use Override;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Repository\Filter\ShapeFilter;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Repository\ShapeRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Shape\Create\ShapeCreateParamsDto;

final readonly class ShapeFactory implements ShapeFactoryInterface
{
    private const string REGEX_HEX_COLOR = '/^[0-9A-Fa-f]{6}$/';

    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private ShapeRepositoryInterface $shapeRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function create(ShapeCreateParamsDto $paramsDto): Shape
    {
        $this->guardInput($paramsDto);

        $existing = $this->findExisting($paramsDto);

        if ($existing !== null) {
            return $existing;
        }

        return new Shape(
            uuid: $this->uuidHelper->create(),
            type: $paramsDto->type,
            x: $paramsDto->x,
            y: $paramsDto->y,
            width: $paramsDto->width,
            height: $paramsDto->height,
            rgbHex: $paramsDto->rgbHex,
            size: $paramsDto->size,
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function guardInput(ShapeCreateParamsDto $paramsDto): void
    {
        Assert::positiveInteger($paramsDto->x);
        Assert::positiveInteger($paramsDto->y);
        Assert::positiveInteger($paramsDto->width);
        Assert::positiveInteger($paramsDto->height);
        Assert::positiveInteger($paramsDto->size);
        Assert::notEmpty($paramsDto->rgbHex);
        Assert::regex($paramsDto->rgbHex, self::REGEX_HEX_COLOR);
    }

    private function findExisting(ShapeCreateParamsDto $paramsDto): ?Shape
    {
        $paginationResult = $this->shapeRepository->findByFilter(
            new ShapeFilter(
                type: $paramsDto->type,
                x: $paramsDto->x,
                y: $paramsDto->y,
                width: $paramsDto->width,
                height: $paramsDto->height,
                rgbHex: $paramsDto->rgbHex,
                size: $paramsDto->size,
            ),
        );

        $shapeList = $paginationResult->items->toArray();

        if (!empty($shapeList)) {
            return current($shapeList);
        }

        return null;
    }
}
