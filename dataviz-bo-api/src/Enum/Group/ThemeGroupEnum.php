<?php

declare(strict_types=1);

namespace App\Enum\Group;

enum ThemeGroupEnum: string
{
    public const GET_COLLECTION = 'theme:get:collection';
    public const GET = 'theme:get';
    public const POST = 'theme:post';
    public const PATCH = 'theme:patch';
}
