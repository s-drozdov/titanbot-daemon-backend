<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Service\Log\Index;

use Override;
use RuntimeException;
use Symfony\Component\Process\Process;
use Titanbot\Daemon\Application\Dto\LogDto;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Service\Log\Index\LogIndexGetServiceInterface;

final readonly class LogIndexGetService implements LogIndexGetServiceInterface
{
    private const string LOG_SHELL_COMMAND_MAIN_TEMPLATE = 'lnav -n %s/%s*';
    private const string LOG_SHELL_COMMAND_FILTER_TEMPLATE = ' | grep -F %s';
    private const string EOL = "\n";
    private const string ERROR_NOT_FOUND = 'reason: No such file or directory';
    
    public function __construct(
        private string $logDir,
        private string $filePrefix,
        private int $shellTimeout,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?string $message): ListInterface
    {
        return new Collection(
            value: array_map(
                fn (string $message): LogDto => new LogDto(message: $message),
                $this->getMessagelist($message),
            ),
            innerType: LogDto::class,
        );
    }

    /**
     * @return array<array-key,string>
     */
    private function getMessagelist(?string $message): array
    {
        $process = Process::fromShellCommandline(
            $this->getShellCommand($message),
        );

        $process->setTimeout($this->shellTimeout);
        $process->run();

        if (!$process->isSuccessful()) {
            return $this->getFromError($process->getErrorOutput());
        }

        return array_filter(
            explode(self::EOL, $process->getOutput()),
        );
    }

    /**
     * @return array<array-key,string>
     */
    private function getFromError(string $error): array
    {
        if (mb_stripos($error, self::ERROR_NOT_FOUND) !== false) {
            return [];
        }

        if ($error === '') {
            return [];
        }

        throw new RuntimeException($error);
    }

    private function getShellCommand(?string $message): string
    {
        $command = sprintf(self::LOG_SHELL_COMMAND_MAIN_TEMPLATE, $this->logDir, $this->filePrefix);

        if ($message !== null && $message !== '') {
            $command .= sprintf(self::LOG_SHELL_COMMAND_FILTER_TEMPLATE, $message);
        }

        return $command;
    }
}
