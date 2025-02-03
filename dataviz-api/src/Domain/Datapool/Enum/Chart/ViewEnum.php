<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Enum\Chart;

enum ViewEnum: string
{
    case POLAR = 'POLAR';
    case CARTESIAN = 'CARTESIAN';
}
