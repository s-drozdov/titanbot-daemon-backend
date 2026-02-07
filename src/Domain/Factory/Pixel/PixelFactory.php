<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Pixel;

use Override;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Dot;
use Titanbot\Daemon\Domain\Entity\Habit\Color;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Repository\Filter\DotFilter;
use Titanbot\Daemon\Domain\Repository\Filter\ColorFilter;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Repository\DotRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\ColorRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Pixel\Create\PixelCreateParamsDto;

final readonly class PixelFactory implements PixelFactoryInterface
{
    private const string REGEX_HEX_COLOR = '/^[0-9A-Fa-f]{6}$/';
    private const int DEFAULT_DEVIATION = 0;

    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private DotRepositoryInterface $dotRepository,
        private ColorRepositoryInterface $colorRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function create(PixelCreateParamsDto $paramsDto): Pixel {
        $this->guardInput($paramsDto);

        $entity = new Pixel(
            uuid: $this->uuidHelper->create(),
            dot: $this->getDot($paramsDto->x, $paramsDto->y),
            color: $this->getColor($paramsDto->rgbHex, $paramsDto->deviation),
        );

        $this->dotRepository->save($entity->getDot());
        $this->colorRepository->save($entity->getColor());

        return $entity;
    }

    /** 
     * @throws InvalidArgumentException
     */
    public function guardInput(PixelCreateParamsDto $paramsDto): void {
        Assert::positiveInteger($paramsDto->x);
        Assert::positiveInteger($paramsDto->y);
        Assert::notEmpty($paramsDto->rgbHex);
        Assert::regex($paramsDto->rgbHex, self::REGEX_HEX_COLOR);

        if ($paramsDto->deviation !== null && $paramsDto->deviation !== 0) {
            Assert::positiveInteger($paramsDto->deviation);
        }
    }

    public function getDot(int $x, int $y): Dot
    {
        $paginationResult = $this->dotRepository->findByFilter(new DotFilter(x: $x, y: $y));
        $dotList = $paginationResult->items->toArray();

        if (!empty($dotList)) {
            return current($dotList);
        }

        return new Dot(
            uuid: $this->uuidHelper->create(),
            x: $x,
            y: $y,
        );
    }

    public function getColor(string $rgbHex, ?int $deviation): Color
    {
        $paginationResult = $this->colorRepository->findByFilter(
            new ColorFilter(rgbHex: $rgbHex, deviation: $deviation),
        );

        $colorList = $paginationResult->items->toArray();

        if (!empty($colorList)) {
            return current($colorList);
        }

        return new Color(
            uuid: $this->uuidHelper->create(),
            rgbHex: $rgbHex,
            deviation: $deviation ?? self::DEFAULT_DEVIATION,
        );
    }
}
