<?php

declare(strict_types=1);

namespace App\Domain\Enum\Dataset;

enum DataProviderEnum: string
{
    case INSEE_TD = 'INSEE_TD';
    case ACCIDENTOLOGY = 'ACCIDENTOLOGY';
}
