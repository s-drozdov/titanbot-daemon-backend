<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
