<?php

declare(strict_types=1);

namespace App\Domain\Datapool\ValueObject\Piic;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class PiicNature
{
    #[ORM\Column(name: 'nature', length: 255)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 255);

        $this->value = $value;
    }
}
