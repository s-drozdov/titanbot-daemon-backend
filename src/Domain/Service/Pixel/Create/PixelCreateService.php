<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Factory\Pixel\PixelFactoryInterface;
use Titanbot\Daemon\Domain\Repository\PixelRepositoryInterface;

final readonly class PixelCreateService implements PixelCreateServiceInterface
{
    public function __construct(
        private PixelFactoryInterface $pixelFactory,
        private PixelRepositoryInterface $pixelRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(int $x, int $y, string $rgbHex, ?int $deviation): Pixel 
    {
        $entity = $this->pixelFactory->create($x, $y, $rgbHex, $deviation);
        
        $this->pixelRepository->save($entity);

        return $entity;
    }
}
