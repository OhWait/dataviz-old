<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

trait AggregateRootSlug
{
    #[ORM\Id]
    #[ORM\Column(name: 'slug', length: 255, unique: true)]
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
