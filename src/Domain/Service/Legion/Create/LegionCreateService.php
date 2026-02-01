<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;
use Titanbot\Daemon\Domain\Factory\Legion\LegionFactoryInterface;

final readonly class LegionCreateService implements LegionCreateServiceInterface
{
    public function __construct(
        private LegionFactoryInterface $legionFactory,
        private LegionRepositoryInterface $legionRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        string $title,
        ?string $extTitle,
        ?int $payDayOfMonth,
    ): Legion {
        $entity = $this->legionFactory->create(
            title: $title,
            extTitle: $extTitle,
            payDayOfMonth: $payDayOfMonth,
        );
        
        $this->legionRepository->save($entity);

        return $entity;
    }
}
