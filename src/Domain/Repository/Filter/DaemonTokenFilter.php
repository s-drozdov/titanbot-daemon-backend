<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository\Filter;

use Override;
use Titanbot\Daemon\Library\Pager\PagerInterface;

final readonly class DaemonTokenFilter implements FilterInterface
{
    public function __construct(
        public ?string $token = null,
        public ?PagerInterface $pager = null,
    ) {
        /*_*/
    }

    #[Override]
    public function getPager(): ?PagerInterface
    {
        return $this->pager;
    }
}
