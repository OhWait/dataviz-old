<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Enum\Dataset;

enum GranularityEnum: string
{
    case OTHER = 'OTHER';

    // Point of interest
    case POI = 'POI';

    case MUNICIPALITY = 'MUNICIPALITY';

    /**
     * @var string public institution for inter-municipal cooperation
     */
    case PIIC = 'PIIC';

    case DEPARTMENT = 'DEPARTMENT';

    case COUNTRY = 'COUNTRY';
}
