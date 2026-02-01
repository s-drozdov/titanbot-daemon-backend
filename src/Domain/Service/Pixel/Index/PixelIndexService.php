<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\PixelRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PixelFilter;

final readonly class PixelIndexService implements PixelIndexServiceInterface
{
    public function __construct(
        private PixelRepositoryInterface $pixelRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?int $x = null, ?int $y = null, ?string $rgbHex = null, ?int $deviation = null): PaginationResult
    {
        return $this->pixelRepository->findByFilter(
            new PixelFilter($x, $y, $rgbHex, $deviation),
        );
    }
}
