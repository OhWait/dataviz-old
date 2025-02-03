<?php

declare(strict_types=1);

namespace App\Presentation\Enum;

enum ProviderGroupEnum: string
{
    public const GET_COLLECTION = 'provider:get:collection';
    public const GET = 'provider:get';
    public const POST = 'provider:post';

    public const POST_IMAGE = 'provider:post:image';    
    public const PATCH = 'provider:patch';
}
