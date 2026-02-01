<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Log\Create;

use Override;
use Psr\Log\LoggerInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;

/**
 * @implements CommandHandlerInterface<LogCreateCommand,LogCreateCommandResult>
 */
final readonly class LogCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LoggerInterface $daemonLogger,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): LogCreateCommandResult
    {
        $this->daemonLogger->info($command->message);

        return new LogCreateCommandResult();
    }
}
