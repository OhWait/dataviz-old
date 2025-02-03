<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures\ByProvider\Etat\Accidentologie;

use App\Infrastructure\Dataviz\Fixtures\AbstractDataEntryFixture;

class DataEntryEtatAccFixture extends AbstractDataEntryFixture
{
    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            DatasetEtatAccFixture::class,
        ];
    }

    public function getDataEntries(): \Generator
    {
        yield [
            'acc-caracteristique',
            'Caractéristiques',
            'etat',
            'acc_caracteristique',
            'accidents',
        ];
        yield [
            'acc-lieu',
            'Lieux',
            'etat',
            'acc_lieu',
            'accidents',
        ];
        yield [
            'acc-vehicule',
            'Véhicules',
            'etat',
            'acc_vehicule',
            'accidents',
        ];
        yield [
            'acc-usager',
            'Usagers',
            'etat',
            'acc_usager',
            'accidents',
        ];
    }
}
