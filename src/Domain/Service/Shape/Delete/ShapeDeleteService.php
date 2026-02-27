<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Shape\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\ShapeRepositoryInterface;

final readonly class ShapeDeleteService implements ShapeDeleteServiceInterface
{
    public function __construct(
        private ShapeRepositoryInterface $shapeRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Shape
    {
        $entity = $this->shapeRepository->getByUuid($uuid);
        $this->shapeRepository->delete($entity);

        return $entity;
    }
}
