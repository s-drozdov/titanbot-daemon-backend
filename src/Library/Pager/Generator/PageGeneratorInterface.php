<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\Pager\Generator;

use Generator;
use Titanbot\Daemon\Library\Pager\PagerInterface;

interface PageGeneratorInterface
{
    /**
     * @return Generator<array-key, PagerInterface, void, void>
     */
    public function generate(int $total, int $perPage = PagerInterface::DEFAULT_LIMIT): Generator;
}
