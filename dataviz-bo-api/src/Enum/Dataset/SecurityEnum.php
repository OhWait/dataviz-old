<?php

declare(strict_types=1);

namespace App\Enum\Dataset;

use App\Shared\Trait\EnumTrait;

enum SecurityEnum: string
{
    use EnumTrait;

    case PUBLIC = 'PUBLIC';
    case PRENIUM = 'PRENIUM';
}
