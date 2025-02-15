<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Enum\Dataset;

use App\Shared\Domain\Enum\EnumTrait;

enum GranularityEnum: string
{
    use EnumTrait;

    case OTHER = 'OTHER';

    /** @var string Point Of Interest */
    case POI = 'POI';

    case MUNICIPALITY = 'MUNICIPALITY';

    /**
     * @var string Public Institution for Inter-municipal Cooperation
     */
    case PIIC = 'PIIC';

    case DEPARTMENT = 'DEPARTMENT';

    case COUNTRY = 'COUNTRY';
}
