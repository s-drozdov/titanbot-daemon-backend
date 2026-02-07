<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Pixel\GetList;

use Override;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Dto\Pixel\Index\PixelIndexParamsDto;
use Titanbot\Daemon\Domain\Dto\Pixel\Create\PixelCreateParamsDto;
use Titanbot\Daemon\Domain\Service\Pixel\Index\PixelIndexServiceInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Create\PixelCreateServiceInterface;

final readonly class PixelListGetService implements PixelListGetServiceInterface
{
    public function __construct(
        private PixelCreateServiceInterface $pixelCreateService,
        private PixelIndexServiceInterface $pixelIndexService,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?ListInterface $pixelList): ?ListInterface
    {
        if ($pixelList === null) {
            return null;
        }

        return new Collection(
            value: array_map(
                fn (PixelRequestDto $pixelRequestDto) => $this->getPixel($pixelRequestDto),
                $pixelList->toArray(),
            ),
            innerType: Pixel::class,
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getPixel(PixelRequestDto $pixelRequestDto): Pixel
    {
        $pixelList = $this->getCurrentPixelList($pixelRequestDto);

        if (!empty($pixelList->toArray())) {
            $pixel = current($pixelList->toArray());
            Assert::notFalse($pixel);

            return $pixel;
        }

        return $this->pixelCreateService->perform(
            new PixelCreateParamsDto(
                x: $pixelRequestDto->x,
                y: $pixelRequestDto->y,
                rgbHex: $pixelRequestDto->rgb_hex,
                deviation: $pixelRequestDto->deviation,
            ),
        );
    }

    /**
     * @return ListInterface<Pixel>
     */
    private function getCurrentPixelList(PixelRequestDto $pixelRequestDto): ListInterface
    {
        $paramsDto = new PixelIndexParamsDto(
            x: $pixelRequestDto->x,
            y: $pixelRequestDto->y,
            rgbHex: $pixelRequestDto->rgb_hex,
            deviation: $pixelRequestDto->deviation,
        );

        $paginationResult = $this->pixelIndexService->perform($paramsDto);

        return $paginationResult->items;
    }
}
