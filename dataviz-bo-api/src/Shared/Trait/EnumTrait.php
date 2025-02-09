<?php

declare(strict_types=1);

namespace App\Shared\Trait;

trait EnumTrait
{
    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
