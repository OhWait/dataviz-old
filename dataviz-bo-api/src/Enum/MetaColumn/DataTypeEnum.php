<?php

declare(strict_types=1);

namespace App\Enum\MetaColumn;

use App\Shared\Trait\EnumTrait;

enum DataTypeEnum: string
{
    use EnumTrait;

    case CHARACTER_VARYING = 'character varying';
    case DATE = 'date';
    case TIME_WTZ = 'time with time zone';
    case TIME_WNTZ = 'time without time zone';
    case TIMESTAMP_WTZ = 'timestamp with time zone';
    case TIMESTAMP_WNTZ = 'timestamp without time zone';
    case NUMERIC = 'numeric';
    case INTEGER = 'integer';
}
