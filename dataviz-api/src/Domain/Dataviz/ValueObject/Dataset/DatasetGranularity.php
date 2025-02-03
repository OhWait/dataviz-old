<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use App\Domain\Dataviz\Enum\Dataset\GranularityEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetGranularity
{
    #[ORM\Column(name: 'granularity', length: 255)]
    public readonly GranularityEnum $value;

    public function __construct(string $value)
    {
        Assert::notNull(GranularityEnum::tryFrom($value));

        $this->value = GranularityEnum::from($value);
    }

    public function value(): string
    {
        return $this->value->value;
    }
}
