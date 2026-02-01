<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Service\Log\Clear;

use Override;
use Titanbot\Daemon\Application\Service\Log\Clear\LogClearServiceInterface;

final readonly class LogClearService implements LogClearServiceInterface
{
    public function __construct(
        private string $logDir,
        private string $filePrefix,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(): void
    {
        $fileList = glob(
            sprintf('%s/%s*', $this->logDir, $this->filePrefix),
        );

        if ($fileList === false) {
            return;
        }

        foreach ($fileList as $file) {
            is_file($file) && @unlink($file);
        }
    }
}
