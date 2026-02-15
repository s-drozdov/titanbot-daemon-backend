<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Repository\SshRepositoryInterface;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;

/**
 * @extends EntityRepository<Ssh>
 */
final class SshRepository extends EntityRepository implements SshRepositoryInterface
{
    /** @use DoctrinePersistable<Ssh> */
    use DoctrinePersistable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Ssh::class));
    }

    #[Override]
    public function findAllPorts(): ListInterface
    {
        $portList = $this->createQueryBuilder('s')
            ->select('s.port')
            ->getQuery()
            ->getSingleColumnResult();

        /** @var ListInterface<int> $result */
        $result = new Collection(
            value: $portList,
            innerType: PhpType::int->value,
        );

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
        return Ssh::class;
    }
}
