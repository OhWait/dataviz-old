<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use App\Domain\Dataviz\Enum\Dataset\FrequencyEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetUpdateFrequency
{
    #[ORM\Column(name: 'update_frequency', length: 255, nullable: true)]
    public readonly ?FrequencyEnum $value;

    public function __construct(?string $value = null)
    {
        if (null !== $value) {
            Assert::notNull(FrequencyEnum::tryFrom($value));

            $this->value = FrequencyEnum::from($value);
        } else {
            $this->value = null;
        }
    }

    public function value(): ?string
    {
        return $this->value?->value;
    }
}
