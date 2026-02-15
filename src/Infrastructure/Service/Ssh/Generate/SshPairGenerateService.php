<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Service\Ssh\Generate;

use Override;
use RuntimeException;
use Symfony\Component\Process\Process;
use Titanbot\Daemon\Application\Dto\SshPairDto;
use Titanbot\Daemon\Domain\Helper\FileSystem\FileSystemHelperInterface;
use Titanbot\Daemon\Application\Service\Ssh\Generate\SshPairGenerateServiceInterface;

final readonly class SshPairGenerateService implements SshPairGenerateServiceInterface
{
    private const string CMD_TEMPLATE = 'ssh-keygen -q -t ed25519 -f %s/id_ed25519 -N "" -C "titanbot%d"';
    private const string DIR_TEMPLATE = '%s/%s%s';
    private const string DIR_PREFIX = 'ssh_gen_';

    private const string PRIVATE_FILE = 'id_ed25519';
    private const string PUBLIC_FILE = 'id_ed25519.pub';

    private const string ERROR_CANNOT_GENERATE = 'Cannot generate ssh pair';

    public function __construct(
        private FileSystemHelperInterface $fileSystemHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(int $physicalId): SshPairDto
    {
        $tempDir = sprintf(self::DIR_TEMPLATE, sys_get_temp_dir(), self::DIR_PREFIX, bin2hex(random_bytes(6)));
        $this->fileSystemHelper->createDirectory($tempDir);
        
        $this->generateKeyFiles($tempDir, $physicalId);
        $sshPairDto = $this->buildDto($tempDir);

        $this->removeKeyFiles($tempDir);
        $this->fileSystemHelper->removeDirectory($tempDir);

        return $sshPairDto;
    }

    private function generateKeyFiles(string $dir, int $physicalId): void
    {
        $process = Process::fromShellCommandline(
            sprintf(self::CMD_TEMPLATE, $dir, $physicalId),
        );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new RuntimeException(self::ERROR_CANNOT_GENERATE);
        }
    }

    private function buildDto(string $dir): SshPairDto
    {
        return new SshPairDto(
            public: $this->fileSystemHelper->readFile(
                sprintf('%s/%s', $dir, self::PUBLIC_FILE),
            ),
            private: $this->fileSystemHelper->readFile(
                sprintf('%s/%s', $dir, self::PRIVATE_FILE),
            ),
        );
    }

    private function removeKeyFiles(string $dir): void
    {
        $this->fileSystemHelper->removeFile(
            sprintf('%s/%s', $dir, self::PUBLIC_FILE),
        );

        $this->fileSystemHelper->removeFile(
            sprintf('%s/%s', $dir, self::PRIVATE_FILE),
        );
    }
}
