<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Command\Query\Cache\HealthCheck;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Titanbot\Daemon\Infrastructure\Enum\ConsoleAction;
use Titanbot\Daemon\Infrastructure\Bus\Processor\CommandBusQueryProcessor;
use Titanbot\Daemon\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQuery;
use Titanbot\Daemon\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQueryResult;
use Titanbot\Daemon\Infrastructure\Enum\ConsoleActionDescription;

#[AsCommand(
    name: ConsoleAction::DignosticsCacheHealthCheck->value,
    description: ConsoleActionDescription::DignosticsCacheHealthCheck->value,
)]
final class CacheHealthCheckQueryCommand extends Command
{
    public function __construct(

        /** @var CommandBusQueryProcessor<CacheHealthCheckQuery,CacheHealthCheckQueryResult> $busProcessor */
        private CommandBusQueryProcessor $busProcessor,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->setHelp(
            sprintf(
                <<<HELPBLOCK
                    usage:
                        bin/console %s
                HELPBLOCK,
                ConsoleAction::DignosticsCacheHealthCheck->value,
            ),
        );
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, CacheHealthCheckQuery::class);
    }
}
