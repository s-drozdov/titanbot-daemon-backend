<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Shape\GetList;

use Override;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Enum\ShapeType;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\ShapeRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Dto\Shape\Index\ShapeIndexParamsDto;
use Titanbot\Daemon\Domain\Dto\Shape\Create\ShapeCreateParamsDto;
use Titanbot\Daemon\Domain\Service\Shape\Index\ShapeIndexServiceInterface;
use Titanbot\Daemon\Domain\Service\Shape\Create\ShapeCreateServiceInterface;

final readonly class ShapeListGetService implements ShapeListGetServiceInterface
{
    public function __construct(
        private ShapeCreateServiceInterface $shapeCreateService,
        private ShapeIndexServiceInterface $shapeIndexService,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?ListInterface $shapeList): ?ListInterface
    {
        if ($shapeList === null) {
            return null;
        }

        return new Collection(
            value: array_map(
                fn (ShapeRequestDto $shapeRequestDto) => $this->getShape($shapeRequestDto),
                $shapeList->toArray(),
            ),
            innerType: Shape::class,
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getShape(ShapeRequestDto $shapeRequestDto): Shape
    {
        $shapeType = ShapeType::from($shapeRequestDto->type);

        $shapeList = $this->getCurrentShapeList($shapeRequestDto, $shapeType);

        if (!empty($shapeList->toArray())) {
            $shape = current($shapeList->toArray());
            Assert::notFalse($shape);

            return $shape;
        }

        return $this->shapeCreateService->perform(
            new ShapeCreateParamsDto(
                type: $shapeType,
                x: $shapeRequestDto->x,
                y: $shapeRequestDto->y,
                width: $shapeRequestDto->width,
                height: $shapeRequestDto->height,
                rgbHex: $shapeRequestDto->rgb_hex,
                size: $shapeRequestDto->size,
            ),
        );
    }

    /**
     * @return ListInterface<Shape>
     */
    private function getCurrentShapeList(ShapeRequestDto $shapeRequestDto, ShapeType $shapeType): ListInterface
    {
        $paramsDto = new ShapeIndexParamsDto(
            type: $shapeType,
            x: $shapeRequestDto->x,
            y: $shapeRequestDto->y,
            width: $shapeRequestDto->width,
            height: $shapeRequestDto->height,
            rgbHex: $shapeRequestDto->rgb_hex,
            size: $shapeRequestDto->size,
        );

        $paginationResult = $this->shapeIndexService->perform($paramsDto);

        return $paginationResult->items;
    }
}
