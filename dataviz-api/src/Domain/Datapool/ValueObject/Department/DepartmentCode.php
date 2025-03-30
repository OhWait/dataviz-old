<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Department;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DepartmentCode
{
    #[ORM\Id]
    #[ORM\Column(name: 'codedep', length: 3)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::maxLength($value, 3);

        $this->value = $value;
    }
}
