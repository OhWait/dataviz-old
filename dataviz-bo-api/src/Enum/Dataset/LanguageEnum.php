<?php

declare(strict_types=1);

namespace App\Enum\Dataset;

use App\Shared\Trait\EnumTrait;

enum LanguageEnum: string
{
    use EnumTrait;

    case FR = 'fr_FR';
    case EN = 'en_US';
}
