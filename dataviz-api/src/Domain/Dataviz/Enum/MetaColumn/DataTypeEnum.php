<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Enum\MetaColumn;

enum DataTypeEnum: string
{
    case CHARACTER_VARYING = 'character varying';
    case DATE = 'date';
    case TIME_WTZ = 'time with time zone';
    case TIME_WNTZ = 'time without time zone';
    case TIMESTAMP_WTZ = 'timestamp with time zone';
    case TIMESTAMP_WNTZ = 'timestamp without time zone';
    case NUMERIC = 'numeric';
    case INTEGER = 'integer';

    public const AGGREGABLE = [
        self::INTEGER,
        self::NUMERIC,
    ];

    public const DATE_AGGREGABLE = [
        self::DATE,
        self::TIME_WTZ,
        self::TIME_WNTZ,
        self::TIMESTAMP_WTZ,
        self::TIMESTAMP_WNTZ,
    ];

    public static function isAggregable(?self $case): bool
    {
        return \in_array($case, self::AGGREGABLE);
    }

    public static function isDateAggregable(?self $case): bool
    {
        return \in_array($case, self::DATE_AGGREGABLE);
    }
}
