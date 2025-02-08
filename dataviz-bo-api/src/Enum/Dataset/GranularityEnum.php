<?php

declare(strict_types=1);

namespace App\Enum\Dataset;

enum GranularityEnum: string
{
    case OTHER = 'OTHER';

    // Point of interest
    case POI = 'POI';

    case MUNICIPALITIE = 'MUNICIPALITIE';

    // Public institution for inter-municipal cooperation
    case PIIC = 'PIIC';

    case DEPARTMENT = 'DEPARTMENT';

    case COUNTRY = 'COUNTRY';
}
