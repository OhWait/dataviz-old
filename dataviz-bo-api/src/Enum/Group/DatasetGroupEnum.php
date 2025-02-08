<?php

declare(strict_types=1);

namespace App\Enum\Group;

enum DatasetGroupEnum: string
{
    public const GET_COLLECTION = 'dataset:get:collection';
    public const GET = 'dataset:get';
    public const POST = 'dataset:post';
    public const PATCH = 'dataset:patch';
}
