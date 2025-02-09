<?php

declare(strict_types=1);

namespace App\Enum\Dataset;

use App\Shared\Trait\EnumTrait;

enum GranularityEnum: string
{
    use EnumTrait;

    case OTHER = 'OTHER';

    // Point of interest
    case POI = 'POI';

    case MUNICIPALITIE = 'MUNICIPALITIE';

    // Public institution for inter-municipal cooperation
    case PIIC = 'PIIC';

    case DEPARTMENT = 'DEPARTMENT';

    case COUNTRY = 'COUNTRY';
}
