<?php

declare(strict_types=1);

namespace App\Enum\Dataset;

use App\Shared\Trait\EnumTrait;

enum FrequencyEnum: string
{
    use EnumTrait;

    case DAILY = 'DAILY';
    case WEEKLY = 'WEEKLY';
    case MONTHLY = 'MONTHLY';
    case QUARTERLY = 'QUARTERLY';
    case HALF_YEARLY = 'HALF_YEARLY';
    case YEARLY = 'YEARLY';
}
