<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Department;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DepartmentYear
{
    #[ORM\Id]
    #[ORM\Column(name: 'annee', type: Types::INTEGER)]
    public readonly int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
