<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Event\Listener\Doctrine\Habit;

use DateTimeImmutable;
use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\EntityInterface;

final class HabitListener
{
    public function onFlush(OnFlushEventArgs $args): void
    {
        $em  = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->updateSheduledEntity($entity, $em, $uow);
        }
    }

    private function updateSheduledEntity(object $entity, EntityManagerInterface $em, UnitOfWork $uow): void
    {
        if (!$entity instanceof Habit) {
            return;
        }

        $entity->setUpdatedAt(new DateTimeImmutable());

        $uow->recomputeSingleEntityChangeSet(
            $em->getClassMetadata(Habit::class), 
            $entity,
        );
    }
}
