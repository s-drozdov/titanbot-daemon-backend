<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Command\Command;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Titanbot\Daemon\Infrastructure\Bus\Processor\CommandBusQueryProcessor;
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get\DaemonDbGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get\DaemonDbGetQueryResult;

#[AsCommand(
    name: 'db:export',
    description: 'Export daemon db',
)]
final class DaemonDbExportCommand extends Command
{
    public function __construct(

        /** @var CommandBusQueryProcessor<DaemonDbGetQuery,DaemonDbGetQueryResult> $busProcessor */
        private CommandBusQueryProcessor $busProcessor,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->setHelp(
            <<<HELPBLOCK
                    usage:
                        bin/console db:export
                HELPBLOCK,
        );
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, DaemonDbGetQuery::class);
    }
}
