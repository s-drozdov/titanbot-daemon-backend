<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\Pager\Generator;

use Override;
use Generator;
use Titanbot\Daemon\Library\Pager\Pager;
use Titanbot\Daemon\Library\Pager\PagerInterface;

final class PageGenerator implements PageGeneratorInterface
{
    private const int DEFAULT_OFFSET = 0;

    #[Override]
    public function generate(int $total, int $perPage = PagerInterface::DEFAULT_LIMIT): Generator
    {
        $offset = self::DEFAULT_OFFSET;

        while ($offset < $total) {
            yield new Pager(
                page: (int) floor($offset / $perPage) + 1,
                perPage: $perPage,
                total: $total,
            );

            $offset += $perPage;
        }
    }
}
