<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Log\CreateBulk;

use Override;
use Psr\Log\LoggerInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;

/**
 * @implements CommandHandlerInterface<LogBulkCreateCommand,LogBulkCreateCommandResult>
 */
final readonly class LogBulkCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LoggerInterface $daemonLogger,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): LogBulkCreateCommandResult
    {
        foreach ($command->log_dto_list->toArray() as $logDto) {
            $this->daemonLogger->info($logDto->message);
        }

        return new LogBulkCreateCommandResult();
    }
}
