<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enum;

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
