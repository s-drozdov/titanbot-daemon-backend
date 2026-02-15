<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Command\Command\Ssh\Create;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Titanbot\Daemon\Infrastructure\Enum\ConsoleAction;
use Titanbot\Daemon\Infrastructure\Enum\ConsoleActionDescription;
use Titanbot\Daemon\Application\UseCase\Command\Ssh\Create\SshCreateCommand;
use Titanbot\Daemon\Infrastructure\Bus\Processor\CommandBusCommandProcessor;
use Titanbot\Daemon\Application\UseCase\Command\Ssh\Create\SshCreateCommandResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;

#[AsCommand(
    name: ConsoleAction::SshRotate->value,
    description: ConsoleActionDescription::SshRotate->value,
)]
final class SshRotateCommandCommand extends Command
{
    private const string PHYSICAL_ID = 'physical_id';
    private const string PORT = 'port';

    public function __construct(

        /** @var CommandBusCommandProcessor<SshCreateCommand,SshCreateCommandResult> $busProcessor */
        private CommandBusCommandProcessor $busProcessor,

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
                            --%s=PHYSICAL_ID \
                            [--%s=PORT]
                    example: 
                        bin/console %s --%s=17 [--%s=2222]
                HELPBLOCK,
                ConsoleAction::SshRotate->value,
                self::PHYSICAL_ID,
                self::PORT,
                ConsoleAction::SshRotate->value,
                self::PHYSICAL_ID,
                self::PORT,
            ),
        );

        $this
            ->addOption(self::PHYSICAL_ID, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::PHYSICAL_ID))
            ->addOption(self::PORT, null, InputOption::VALUE_OPTIONAL, $this->stringHelper->snakeToHumanReadable(self::PORT))
        ;
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, SshCreateCommand::class);
    }
}
