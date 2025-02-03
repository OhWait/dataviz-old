<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\DataEntry;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DataEntrySchemaName implements \Stringable
{
    #[ORM\Column(name: 'schema_name', length: 255)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 255);

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
