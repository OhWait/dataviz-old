<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Piic;

final class PiicNbMunicipalities
{
    public readonly int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
