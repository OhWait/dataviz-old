<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Insee;

use App\Enum\Dataset\DataProviderEnum;
use App\Enum\Dataset\FrequencyEnum;
use App\Enum\Dataset\GranularityEnum;
use App\Enum\Dataset\LanguageEnum;
use App\Enum\Dataset\SecurityEnum;
use App\Fixtures\AbstractDatasetFixture;

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
            GranularityEnum::MUNICIPALITY->value,
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
