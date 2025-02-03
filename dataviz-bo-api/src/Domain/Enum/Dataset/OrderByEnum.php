<?php

declare(strict_types=1);

namespace App\Domain\Enum\Dataset;

enum OrderByEnum: string
{
    case DATA_UPDATED_AT = 'dataUpdatedAt';
    case CATEGORY = 'category';
}
