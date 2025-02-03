<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\ValueObject\Dataset;

use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class DatasetDataProvider
{
    #[ORM\Column(name: 'data_provider', length: 255, nullable: true)]
    public readonly ?DataProviderEnum $value;

    public function __construct(?string $value = null)
    {
        if (null !== $value) {
            Assert::notNull(DataProviderEnum::tryFrom($value));

            $this->value = DataProviderEnum::from($value);
        } else {
            $this->value = null;
        }
    }

    public function value(): ?string
    {
        return $this->value?->value;
    }
}
