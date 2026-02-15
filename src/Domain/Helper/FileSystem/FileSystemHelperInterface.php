<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Helper\FileSystem;

use RuntimeException;
use Titanbot\Daemon\Domain\Helper\HelperInterface;

interface FileSystemHelperInterface extends HelperInterface
{
    /**
     * @throws RuntimeException
     */
    public function createDirectory(string $dir): string;

    /**
     * @throws RuntimeException
     */
    public function removeDirectory(string $dir): void;

    /**
     * @throws RuntimeException
     */
    public function readFile(string $file): string;

    /**
     * @throws RuntimeException
     */
    public function removeFile(string $file): void;
}
