<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Command\Habit\Update;

use Override;
use Webmozart\Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Application\Dto\ShapeRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Command\Habit\Update\HabitUpdateCommand;

/**
 * @extends AbstractValueResolver<HabitUpdateCommand>
 */
final readonly class HabitUpdateCommandValueResolver extends AbstractValueResolver
{
    private const string PIXEL_LIST = 'pixel_list';
    private const string SHAPE_LIST = 'shape_list';

    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
        private UuidHelperInterface $uuidHelper,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return HabitUpdateCommand::class;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType [INFO]
     * @psalm-suppress LessSpecificReturnStatement [INFO]
     */
    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $uuid = $request->attributes->get('uuid');
        Assert::string($uuid);

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

        return $this->denormalizer->denormalize(
            [
                'uuid' => $this->uuidHelper->fromString($uuid),
                ...$data,
            ],
            $this->getTargetClass(),
        );
    }
}