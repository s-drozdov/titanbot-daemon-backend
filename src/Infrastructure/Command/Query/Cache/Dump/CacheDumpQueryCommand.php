<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Command\Query\Cache\Dump;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Titanbot\Daemon\Infrastructure\Enum\ConsoleAction;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Infrastructure\Enum\ConsoleActionDescription;
use Titanbot\Daemon\Application\UseCase\Query\Cache\Dump\CacheDumpQuery;
use Titanbot\Daemon\Infrastructure\Bus\Processor\CommandBusQueryProcessor;
use Titanbot\Daemon\Application\UseCase\Query\Cache\Dump\CacheDumpQueryResult;

#[AsCommand(
    name: ConsoleAction::DignosticsCacheDump->value,
    description: ConsoleActionDescription::DignosticsCacheDump->value,
)]
final class CacheDumpQueryCommand extends Command
{
    private const string KEY = 'key';

    public function __construct(

        /** @var CommandBusQueryProcessor<CacheDumpQuery,CacheDumpQueryResult> $busProcessor */
        private CommandBusQueryProcessor $busProcessor,

        private StringHelperInterface $stringHelper,
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
                        bin/console %s \
                            --%s=KEY
                    example: 
                        bin/console %s --%s=SomeEntity.d58726ad-eafb-4659-a1b7-9c72a2a38f78
                HELPBLOCK,
                ConsoleAction::DignosticsCacheDump->value,
                self::KEY,
                ConsoleAction::DignosticsCacheDump->value,
                self::KEY,
            ),
        );

        $this->addOption(self::KEY, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::KEY));
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, CacheDumpQuery::class);
    }
}
