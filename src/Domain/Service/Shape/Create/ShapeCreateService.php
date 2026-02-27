<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Factory\Shape\ShapeFactoryInterface;
use Titanbot\Daemon\Domain\Repository\ShapeRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Shape\Create\ShapeCreateParamsDto;

final readonly class ShapeCreateService implements ShapeCreateServiceInterface
{
    public function __construct(
        private ShapeFactoryInterface $shapeFactory,
        private ShapeRepositoryInterface $shapeRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(ShapeCreateParamsDto $paramsDto): Shape
    {
        $entity = $this->shapeFactory->create($paramsDto);

        $this->shapeRepository->save($entity);

        return $entity;
    }
}
