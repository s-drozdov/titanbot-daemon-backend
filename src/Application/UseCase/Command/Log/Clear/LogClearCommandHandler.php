<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Log\Clear;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Application\Service\Log\Clear\LogClearServiceInterface;

/**
 * @implements CommandHandlerInterface<LogClearCommand,LogClearCommandResult>
 */
final readonly class LogClearCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LogClearServiceInterface $logClearService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): LogClearCommandResult
    {
        $this->logClearService->perform();

        return new LogClearCommandResult();
    }
}
