<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Department;

final class DepartmentNbMunicipalities
{
    public readonly int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
