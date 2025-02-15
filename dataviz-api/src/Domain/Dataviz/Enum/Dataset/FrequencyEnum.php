<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Enum\Dataset;

use App\Shared\Domain\Enum\EnumTrait;

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
