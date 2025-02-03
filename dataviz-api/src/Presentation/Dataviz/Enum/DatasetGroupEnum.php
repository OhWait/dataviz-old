<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Enum;

enum DatasetGroupEnum: string
{
    public const GET_COLLECTION = 'dataset:get:collection';
    public const GET = 'dataset:get';
}
