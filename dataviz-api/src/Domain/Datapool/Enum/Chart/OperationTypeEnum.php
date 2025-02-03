<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Enum\Chart;

enum OperationTypeEnum: string
{
    case SUM = 'SUM';
    case COUNT = 'COUNT';
    case DISTINCT = 'DISTINCT';
    case COUNT_DISTINCT = 'COUNT_DISTINCT';
    case BY_MONTH = 'BY_MONTH';
    case BY_DAY = 'BY_DAY';
    case BY_HOUR = 'BY_HOUR';
    case BY_DAY_OF_THE_WEEK = 'BY_DAY_OF_THE_WEEK';
    case YEARLY = 'YEARLY';
    case MONTHLY = 'MONTHLY';
    case DAILY = 'DAILY';

    public const AGGREGATE_OPERATION = [
        self::SUM->value => 'SUM(%s)',
        self::COUNT->value => 'COUNT(%s)',
        self::COUNT_DISTINCT->value => 'COUNT(DISTINCT(%s))',
    ];

    public const AGGREGATE_DATE = [
        self::BY_MONTH->value => 'to_char(%s, \'TMMonth\')',
        self::BY_DAY->value => 'to_char(%s, \'DD\')',
        self::BY_DAY_OF_THE_WEEK->value => 'to_char(%s, \'TMDay\')',
        self::BY_HOUR->value => 'to_char(%s, \'HH24\')',
        self::YEARLY->value => 'to_char(%s, \'YYYY\')',
        self::MONTHLY->value => 'to_char(%s, \'YYYY-MM\')',
        self::DAILY->value => 'to_char(%s, \'YYYY-MM-DD\')',
    ];

    public const STRICT_AGGREGABLE = [
        self::SUM,
    ];

    public static function toOperation(self $case): string
    {
        return self::AGGREGATE_OPERATION[$case->value];
    }

    public static function toAggregateDate(self $case): string
    {
        return self::AGGREGATE_DATE[$case->value];
    }

    public static function isStrictAggregableOperation(?self $case): bool
    {
        return \in_array($case, self::STRICT_AGGREGABLE);
    }
}
