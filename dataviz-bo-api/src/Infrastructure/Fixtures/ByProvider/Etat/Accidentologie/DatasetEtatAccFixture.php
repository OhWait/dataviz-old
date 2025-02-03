<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures\ByProvider\Etat\Accidentologie;

use App\Domain\Enum\Dataset\DataProviderEnum;
use App\Domain\Enum\Dataset\FrequencyEnum;
use App\Domain\Enum\Dataset\GranularityEnum;
use App\Domain\Enum\Dataset\LanguageEnum;
use App\Domain\Enum\Dataset\SecurityEnum;
use App\Infrastructure\Fixtures\AbstractDatasetFixture;

class DatasetEtatAccFixture extends AbstractDatasetFixture
{
    protected function getDatasets(): \Generator
    {
        yield $this->overload(
            'accidents',
            'Bases de données annuelles des accidents corporels de la circulation routière',
            'Accidents de la circulation',
        );
    }

    private function overload(
        string $slug,
        string $title,
        string $shortTitle,
    ): array {
        return [
            $slug,
            $title,
            $shortTitle,
            null,
            'France',
            GranularityEnum::POI->value,
            FrequencyEnum::YEARLY->value,
            'Décembre',
            SecurityEnum::PUBLIC->value,
            LanguageEnum::FR->value,
            new \DateTime('2013-07-08'),
            new \DateTime('2022-11-30'),
            'miom',
            DataProviderEnum::ACCIDENTOLOGY->value,
            ['mobilite'],
        ];
    }
}
