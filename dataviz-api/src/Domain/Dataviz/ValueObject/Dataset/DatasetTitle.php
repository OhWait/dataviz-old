<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetTitle
{
    #[ORM\Column(name: 'title', length: 255)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 255);

        $this->value = $value;
    }
}
