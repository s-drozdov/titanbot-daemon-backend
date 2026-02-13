<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Event\Subscriber\Doctrine\Habit;

use Override;
use DateTimeImmutable;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class HabitSubscriber implements EventSubscriberInterface
{
    #[Override]
    public static function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate => 'onPreUpdate',
        ];
    }

    public function onPreUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        
        if (!$entity instanceof Habit) {
            return;
        }
        
        $entity->setUpdatedAt(new DateTimeImmutable());
    }
}
