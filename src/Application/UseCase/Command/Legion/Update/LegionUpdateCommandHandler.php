<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Legion\Update;

use Override;
use Titanbot\Daemon\Application\Dto\Mapper\LegionMapper;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Domain\Dto\Legion\Update\LegionUpdateParamsDto;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Legion\Update\LegionUpdateServiceInterface;

/**
 * @implements CommandHandlerInterface<LegionUpdateCommand,LegionUpdateCommandResult>
 */
final readonly class LegionUpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LegionUpdateServiceInterface $legionUpdateService,

        /** @var LegionMapper $legionMapper */
        private LegionMapper $legionMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): LegionUpdateCommandResult
    {
        $paramsDto = new LegionUpdateParamsDto(
            uuid: $command->uuid,
            title: $command->title,
            extTitle: $command->ext_title,
            payDayOfMonth: $command->pay_day_of_month,
        );

        $entity = $this->legionUpdateService->perform($paramsDto);

        return new LegionUpdateCommandResult(
            legion: $this->legionMapper->mapDomainObjectToDto($entity),
        );
    }
}
