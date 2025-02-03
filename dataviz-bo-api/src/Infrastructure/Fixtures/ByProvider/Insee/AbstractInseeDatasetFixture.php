<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures\ByProvider\Insee;

use App\Domain\Enum\Dataset\DataProviderEnum;
use App\Domain\Enum\Dataset\FrequencyEnum;
use App\Domain\Enum\Dataset\GranularityEnum;
use App\Domain\Enum\Dataset\LanguageEnum;
use App\Domain\Enum\Dataset\SecurityEnum;
use App\Infrastructure\Fixtures\AbstractDatasetFixture;

abstract class AbstractInseeDatasetFixture extends AbstractDatasetFixture
{
    protected function getBaseDataset(
        string $slug,
        string $title,
        string $shortTitle,
        array $themes,
    ): array {
        return [
            $slug,
            $title,
            $shortTitle,
            null,
            'France métropolitaine',
            GranularityEnum::MUNICIPALITIE->value,
            FrequencyEnum::YEARLY->value,
            'Juin',
            SecurityEnum::PUBLIC->value,
            LanguageEnum::FR->value,
            new \DateTime('2009-06-30'),
            new \DateTime('2023-06-30'),
            'insee',
            DataProviderEnum::INSEE_TD->value,
            $themes,
        ];
    }
}
