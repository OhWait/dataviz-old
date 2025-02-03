<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enum;

enum ViolationTypeEnum: string
{
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
}
