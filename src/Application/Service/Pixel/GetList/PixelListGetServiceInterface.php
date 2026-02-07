<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Pixel\GetList;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;

interface PixelListGetServiceInterface
{
    /** 
     * @param ListInterface<PixelRequestDto>|null $pixelList
     * 
     * @return ListInterface<Pixel>
     * @throws InvalidArgumentException
     */
    public function perform(?ListInterface $pixelList): ?ListInterface;
}
