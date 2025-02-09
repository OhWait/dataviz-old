<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Insee\Menage;

use App\Fixtures\ByProvider\Insee\AbstractInseeDatasetFixture;

class DatasetInseeMenFixture extends AbstractInseeDatasetFixture
{
    protected function getDatasets(): \Generator
    {
        yield $this->getBaseDataset(
            'men1',
            'Ménages par taille du ménage et catégorie socioprofessionnelle de la personne de référence',
            'Ménages / CSP',
            ['population'],
        );
        yield $this->getBaseDataset(
            'men2',
            'Population des ménages par taille du ménage et catégorie socioprofessionnelle de la personne de référence',
            'Population ménages / CSP',
            ['population'],
        );
        yield $this->getBaseDataset(
            'men3',
            'Ménages par sexe, âge et type d\'activité de la personne de référence âgée de 15 ans ou plus',
            'Ménage / Type d\'activité',
            ['population'],
        );
        yield $this->getBaseDataset(
            'men4',
            'Ménages par taille du ménage, sexe et âge de la personne de référence',
            'Ménages',
            ['population'],
        );
        yield $this->getBaseDataset(
            'men5',
            'Ménages par type de ménage et âge de la personne de référence',
            'Ménages / Type',
            ['population'],
        );
        yield $this->getBaseDataset(
            'men6',
            'Population des ménages par type de ménage et âge de la personne de référence',
            'Population / Type',
            ['population'],
        );
        yield $this->getBaseDataset(
            'men7',
            'Population des ménages par sexe, âge et mode de cohabitation',
            'Population / Mode de cohabitation',
            ['population'],
        );
    }
}
