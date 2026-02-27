<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Command\Habit\Create;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Application\Dto\ShapeRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Command\Habit\Create\HabitCreateCommand;

/**
 * @extends AbstractValueResolver<HabitCreateCommand>
 */
final readonly class HabitCreateCommandValueResolver extends AbstractValueResolver
{
    private const string PIXEL_LIST = 'pixel_list';
    private const string SHAPE_LIST = 'shape_list';

    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return HabitCreateCommand::class;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType [INFO]
     * @psalm-suppress LessSpecificReturnStatement [INFO]
     */
    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $data = $request->toArray();

        $pixelList = $data[self::PIXEL_LIST] ?? null;

        if ($pixelList !== null) {
            $data[self::PIXEL_LIST] = [
                ListInterface::PROPERTY_VALUE => $pixelList,
                ListInterface::PROPERTY_INNER_TYPE => PixelRequestDto::class,
            ];
        }

        $shapeList = $data[self::SHAPE_LIST] ?? null;

        if ($shapeList !== null) {
            $data[self::SHAPE_LIST] = [
                ListInterface::PROPERTY_VALUE => $shapeList,
                ListInterface::PROPERTY_INNER_TYPE => ShapeRequestDto::class,
            ];
        }

        return $this->denormalizer->denormalize($data, $this->getTargetClass());
    }
}