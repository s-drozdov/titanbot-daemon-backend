<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Repository\Filter\ShapeFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\ShapeRepositoryInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;

/**
 * @extends EntityRepository<Shape>
 */
final class ShapeRepository extends EntityRepository implements ShapeRepositoryInterface
{
    /** @use DoctrinePersistable<Shape> */
    use DoctrinePersistable;

    /** @use Paginable<Shape> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Shape::class));
    }

    #[Override]
    public function findByFilter(ShapeFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('s');

        if ($filter->type !== null) {
            $qb
                ->andWhere('s.type = :type')
                ->setParameter('type', $filter->type->value, Types::STRING)
            ;
        }

        if ($filter->x !== null) {
            $qb
                ->andWhere('s.x = :x')
                ->setParameter('x', $filter->x, Types::INTEGER)
            ;
        }

        if ($filter->y !== null) {
            $qb
                ->andWhere('s.y = :y')
                ->setParameter('y', $filter->y, Types::INTEGER)
            ;
        }

        if ($filter->width !== null) {
            $qb
                ->andWhere('s.width = :width')
                ->setParameter('width', $filter->width, Types::INTEGER)
            ;
        }

        if ($filter->height !== null) {
            $qb
                ->andWhere('s.height = :height')
                ->setParameter('height', $filter->height, Types::INTEGER)
            ;
        }

        if ($filter->rgbHex !== null && $filter->rgbHex !== '') {
            $qb
                ->andWhere('s.rgbHex = :rgbHex')
                ->setParameter('rgbHex', $filter->rgbHex, Types::STRING)
            ;
        }

        if ($filter->size !== null) {
            $qb
                ->andWhere('s.size = :size')
                ->setParameter('size', $filter->size, Types::INTEGER)
            ;
        }

        /** @var PaginationResult<Shape> $result */
        $result = $this->paginate($qb, $filter, Shape::class, 's');

        return $result;
    }

    #[Override]
    private function getStringHelper(): StringHelperInterface
    {
        return $this->stringHelper;
    }

    #[Override]
    private function getEntityFqcn(): string
    {
        return Shape::class;
    }
}
