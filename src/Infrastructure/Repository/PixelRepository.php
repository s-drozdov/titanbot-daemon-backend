<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Repository\Filter\PixelFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\PixelRepositoryInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;

/**
 * @extends EntityRepository<Pixel>
 */
final class PixelRepository extends EntityRepository implements PixelRepositoryInterface
{
    /** @use DoctrinePersistable<Pixel> */
    use DoctrinePersistable;

    /** @use Paginable<Pixel> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Pixel::class));
    }
    
    #[Override]
    public function findByFilter(PixelFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.dot', 'd')
            ->join('p.color', 'c')
        ;

        if ($filter->x !== null) {
            $qb
                ->andWhere('d.x = :x')
                ->setParameter('x', $filter->x, Types::INTEGER)
            ;
        }

        if ($filter->y !== null) {
            $qb
                ->andWhere('d.y = :y')
                ->setParameter('y', $filter->y, Types::INTEGER)
            ;
        }

        if ($filter->rgbHex !== null && $filter->rgbHex !== '') {
            $qb
                ->andWhere('c.rgbHex = :rgbHex')
                ->setParameter('rgbHex', $filter->rgbHex, Types::STRING)
            ;
        }

        if ($filter->deviation !== null) {
            $qb
                ->andWhere('c.deviation = :deviation')
                ->setParameter('deviation', $filter->deviation, Types::INTEGER)
            ;
        }

        /** @var PaginationResult<Pixel> $result */
        $result = $this->paginate($qb, $filter, Pixel::class, 'p');

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
        return Pixel::class;
    }
}
