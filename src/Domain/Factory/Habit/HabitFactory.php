<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Habit;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Create\HabitCreateParamsDto;

final readonly class HabitFactory implements HabitFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(HabitCreateParamsDto $paramsDto): Habit 
    {
        $entity = new Habit(
            uuid: $this->uuidHelper->create(),
            accountLogicalId: $paramsDto->accountLogicalId,
            priority: $paramsDto->priority,
            triggerOcr: $paramsDto->triggerOcr,
            triggerShell: $paramsDto->triggerShell,
            logTemplate: $paramsDto->logTemplate,
            postTimeoutMs: $paramsDto->postTimeoutMs,
            action: $paramsDto->action,
            isActive: $paramsDto->isActive,
            comment: $paramsDto->comment,
            sequence: $paramsDto->sequence,
        );

        if ($paramsDto->pixelList !== null) {
            $entity->setPixelList(new ArrayCollection($paramsDto->pixelList->toArray()));
        }

        return $entity;
    }
}
