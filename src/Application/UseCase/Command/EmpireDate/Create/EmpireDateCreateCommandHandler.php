<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\EmpireDate\Create\EmpireDateCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<EmpireDateCreateCommand,EmpireDateCreateCommandResult>
 */
final readonly class EmpireDateCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmpireDateCreateServiceInterface $empireDateCreateService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): EmpireDateCreateCommandResult
    {
        $entity = $this->empireDateCreateService->perform(date: $command->date);

        return new EmpireDateCreateCommandResult(uuid: $entity->getUuid());
    }
}
