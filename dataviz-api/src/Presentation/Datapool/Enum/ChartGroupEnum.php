<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Enum;

enum ChartGroupEnum: string
{
    public const POLAR = 'chart:polar';
    public const CARTESIAN = 'chart:cartesian';
    public const CHART = 'chart';
}
