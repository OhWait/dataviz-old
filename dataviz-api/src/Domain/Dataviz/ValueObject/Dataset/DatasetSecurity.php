<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use App\Domain\Dataviz\Enum\Dataset\SecurityEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetSecurity
{
    #[ORM\Column(name: 'security', length: 255)]
    public readonly SecurityEnum $value;

    public function __construct(string $value)
    {
        Assert::notNull(SecurityEnum::tryFrom($value));

        $this->value = SecurityEnum::from($value);
    }

    public function value(): string
    {
        return $this->value->value;
    }
}
