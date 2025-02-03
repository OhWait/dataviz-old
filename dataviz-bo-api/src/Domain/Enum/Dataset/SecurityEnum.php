<?php

declare(strict_types=1);

namespace App\Domain\Enum\Dataset;

enum SecurityEnum: string
{
    case PUBLIC = 'PUBLIC';
    case PRENIUM = 'PRENIUM';
}
