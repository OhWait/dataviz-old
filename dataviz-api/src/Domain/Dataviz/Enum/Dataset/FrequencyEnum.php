<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Enum\Dataset;

enum FrequencyEnum: string
{
    case DAILY = 'DAILY';
    case WEEKLY = 'WEEKLY';
    case MONTHLY = 'MONTHLY';
    case QUARTERLY = 'QUARTERLY';
    case HALF_YEARLY = 'HALF_YEARLY';
    case YEARLY = 'YEARLY';
}
