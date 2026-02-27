<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Enum;

enum ShapeType: string
{
    case Rectangle = 'rectangle';
    case Circle = 'circle';
    case Triangle = 'triangle';
    case Irregular = 'irregular';
}
