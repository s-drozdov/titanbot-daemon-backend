<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PixelFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Dto\Pixel\Index\PixelIndexParamsDto;
use Titanbot\Daemon\Domain\Repository\PixelRepositoryInterface;

final readonly class PixelIndexService implements PixelIndexServiceInterface
{
    public function __construct(
        private PixelRepositoryInterface $pixelRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(PixelIndexParamsDto $paramsDto): PaginationResult
    {
        return $this->pixelRepository->findByFilter(
            new PixelFilter($paramsDto->x, $paramsDto->y, $paramsDto->rgbHex, $paramsDto->deviation),
        );
    }
}
