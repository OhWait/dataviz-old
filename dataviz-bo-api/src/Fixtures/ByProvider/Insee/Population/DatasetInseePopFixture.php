<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Insee\Population;

use App\Fixtures\ByProvider\Insee\AbstractInseeDatasetFixture;

class DatasetInseePopFixture extends AbstractInseeDatasetFixture
{
    protected function getDatasets(): \Generator
    {
        yield $this->getBaseDataset(
            'pop1a',
            'Population par sexe et âge regroupé',
            'Âge regroupé',
            ['population'],
        );
        yield $this->getBaseDataset(
            'pop1b',
            'Population par sexe et âge',
            'Âge',
            ['population'],
        );
        yield $this->getBaseDataset(
            'pop2',
            'Population par sexe, âge et catégorie de population',
            'Catégorie de la population',
            ['population'],
        );
        yield $this->getBaseDataset(
            'pop3',
            'Population de 15 ans ou plus par sexe, âge et statut conjugal',
            'Statut conjugal',
            ['population'],
        );
        yield $this->getBaseDataset(
            'pop4',
            'Population de 15 ans ou plus par sexe, âge et vie en couple',
            'Vie en couple',
            ['population'],
        );
        yield $this->getBaseDataset(
            'pop5',
            'Population de 15 ans ou plus par sexe, âge et type d\'activité',
            'Type d\'activité',
            ['population'],
        );
        yield $this->getBaseDataset(
            'pop6',
            'Population de 15 ans ou plus par sexe, âge et catégorie socioprofessionnelle',
            'Catégorie socioprofessionnelle',
            ['population'],
        );
    }
}
