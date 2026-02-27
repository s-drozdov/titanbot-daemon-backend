<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\ShapeFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Dto\Shape\Index\ShapeIndexParamsDto;
use Titanbot\Daemon\Domain\Repository\ShapeRepositoryInterface;

final readonly class ShapeIndexService implements ShapeIndexServiceInterface
{
    public function __construct(
        private ShapeRepositoryInterface $shapeRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(ShapeIndexParamsDto $paramsDto): PaginationResult
    {
        return $this->shapeRepository->findByFilter(
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
    }
}
