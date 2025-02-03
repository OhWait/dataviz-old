<?php

declare(strict_types=1);

namespace App\Presentation\Enum;

enum DataEntryGroupEnum: string
{
    public const GET_COLLECTION = 'data-entry:get:collection';
    public const GET = 'data-entry:get';
    public const POST = 'data-entry:post';
    public const PATCH = 'data-entry:patch';
}
