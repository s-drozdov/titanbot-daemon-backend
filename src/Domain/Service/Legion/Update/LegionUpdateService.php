<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Update;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Legion\Update\LegionUpdateParamsDto;

final readonly class LegionUpdateService implements LegionUpdateServiceInterface
{
    public function __construct(
        private LegionRepositoryInterface $legionRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(LegionUpdateParamsDto $paramsDto): Legion {
        $entity = $this->legionRepository->getByUuid($paramsDto->uuid);

        if ($paramsDto->title !== null) {
            $entity->setTitle($paramsDto->title);
        }

        if ($paramsDto->extTitle !== null) {
            $entity->setExtTitle($paramsDto->extTitle);
        }

        if ($paramsDto->payDayOfMonth !== null) {
            $entity->setPayDayOfMonth($paramsDto->payDayOfMonth);
        }

        $this->legionRepository->update($entity);

        return $entity;
    }
}
