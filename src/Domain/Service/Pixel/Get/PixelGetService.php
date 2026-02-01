<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Get;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\PixelRepositoryInterface;

final readonly class PixelGetService implements PixelGetServiceInterface
{
    public function __construct(
        private PixelRepositoryInterface $pixelRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Pixel
    {
        return $this->pixelRepository->getByUuid($uuid);
    }
}
