<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Update;

use InvalidArgumentException;
use Override;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\Filter\AccountFilter;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Device\Update\DeviceUpdateParamsDto;
use Webmozart\Assert\Assert;

final readonly class DeviceUpdateService implements DeviceUpdateServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(DeviceUpdateParamsDto $paramsDto): Device {
        $entity = $this->deviceRepository->getByUuid($paramsDto->uuid);

        if ($paramsDto->currentLogicalId !== null) {
            $this->setDeviceAccount($entity, $paramsDto->currentLogicalId);
        }

        if ($paramsDto->isActive !== null) {
            $entity->setIsActive($paramsDto->isActive);
        }

        if ($paramsDto->isSsh !== null) {
            $entity->setIsSsh($paramsDto->isSsh);
        }

        if ($paramsDto->activityType !== null) {
            $entity->setActivityType($paramsDto->activityType);
        }

        if ($paramsDto->isFullServerDetection !== null) {
            $entity->setIsFullServerDetection($paramsDto->isFullServerDetection);
        }

        if ($paramsDto->isAbleToClearCache !== null) {
            $entity->setIsAbleToClearCache($paramsDto->isAbleToClearCache);
        }

        if ($paramsDto->goTimeLimitSeconds !== null) {
            $entity->setGoTimeLimitSeconds($paramsDto->goTimeLimitSeconds);
        }

        $this->deviceRepository->update($entity);

        return $entity;
    }
    
    /**
     * @throw InvalidArgumentException
     */
    private function setDeviceAccount(Device $entity, int $logicalId): void
    {
        $account = $this->getAccount($logicalId);

        $accountList = $entity->getAccountList();
        $accountList->add($account);

        $entity->setCurrentAccount($account);
    }
    
    /**
     * @throw InvalidArgumentException
     */
    private function getAccount(int $logicalId): Account
    {
        $paginationResult = $this->accountRepository->findByFilter(
            new AccountFilter(logicalId: $logicalId),
        );

        $account = current($paginationResult->items->toArray());
        Assert::notFalse($account);

        return $account;
    }
}
