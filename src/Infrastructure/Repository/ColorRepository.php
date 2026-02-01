<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Color;
use Titanbot\Daemon\Domain\Repository\Filter\ColorFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\ColorRepositoryInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;

/**
 * @extends EntityRepository<Color>
 */
final class ColorRepository extends EntityRepository implements ColorRepositoryInterface
{
    /** @use DoctrinePersistable<Color> */
    use DoctrinePersistable;

    /** @use Paginable<Color> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Color::class));
    }
    
    #[Override]
    public function findByFilter(ColorFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('c');

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

        /** @var PaginationResult<Color> $result */
        $result = $this->paginate($qb, $filter, Color::class, 'c');

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
        return Color::class;
    }
}
