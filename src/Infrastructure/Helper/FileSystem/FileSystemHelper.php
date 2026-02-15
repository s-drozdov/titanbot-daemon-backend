<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Helper\FileSystem;

use Override;
use RuntimeException;
use Titanbot\Daemon\Domain\Helper\FileSystem\FileSystemHelperInterface;

final readonly class FileSystemHelper implements FileSystemHelperInterface
{
    private const string ERROR_CANNOT_DIR = 'Cannot %s directory %s';
    private const string ERROR_CANNOT_FILE = 'Cannot %s file %s';
    
    #[Override]
    public function createDirectory(string $dir): string
    {
        if (mkdir($dir, 0700, true) || is_dir($dir)) {
            return $dir;
        }

        throw new RuntimeException(
            sprintf(self::ERROR_CANNOT_DIR, 'create', $dir),
        );
    }

    #[Override]
    public function removeDirectory(string $dir): void
    {
        if (is_dir($dir)) {
            rmdir($dir);

            return;
        }

        throw new RuntimeException(
            sprintf(self::ERROR_CANNOT_DIR, 'remove', $dir),
        );
    }

    #[Override]
    public function readFile(string $file): string
    {
        if (!is_file($file) || !is_readable($file)) {
            throw new RuntimeException(
                sprintf(self::ERROR_CANNOT_FILE, 'read', $file),
            );
        }
        
        $result = file_get_contents($file);

        if ($result !== false) {
            return $result;
        }

        throw new RuntimeException(
            sprintf(self::ERROR_CANNOT_FILE, 'read', $file),
        );
    }

    #[Override]
    public function removeFile(string $file): void
    {
        if (is_file($file) && is_writable($file)) {
            unlink($file);

            return;
        }

        throw new RuntimeException(
            sprintf(self::ERROR_CANNOT_FILE, 'remove', $file),
        );
    }
}
