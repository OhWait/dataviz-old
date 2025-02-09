<?php

declare(strict_types=1);

namespace App\Enum\Dataset;

use App\Shared\Trait\EnumTrait;

enum DataProviderEnum: string
{
    use EnumTrait;

    case INSEE_TD = 'INSEE_TD';
    case ACCIDENTOLOGY = 'ACCIDENTOLOGY';
}
