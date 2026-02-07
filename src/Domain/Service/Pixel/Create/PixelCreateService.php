<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Pixel\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Factory\Pixel\PixelFactoryInterface;
use Titanbot\Daemon\Domain\Repository\PixelRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Pixel\Create\PixelCreateParamsDto;

final readonly class PixelCreateService implements PixelCreateServiceInterface
{
    public function __construct(
        private PixelFactoryInterface $pixelFactory,
        private PixelRepositoryInterface $pixelRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(PixelCreateParamsDto $paramsDto): Pixel 
    {
        $entity = $this->pixelFactory->create($paramsDto);
        
        $this->pixelRepository->save($entity);

        return $entity;
    }
}
