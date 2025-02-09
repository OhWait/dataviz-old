<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Insee\Menage;

use App\Fixtures\AbstractDataEntryFixture;

class DataEntryInseeMenFixture extends AbstractDataEntryFixture
{
    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            DatasetInseeMenFixture::class,
        ];
    }

    protected function getDataEntries(): \Generator
    {
        $schemaName = 'insee';

        yield [
            'men1',
            'Ménages par taille du ménage et catégorie socioprofessionnelle de la personne de référence',
            $schemaName,
            'men1',
            'men1',
        ];
        yield [
            'men2',
            'Population des ménages par taille du ménage et catégorie socioprofessionnelle de la personne de référence',
            $schemaName,
            'men2',
            'men2',
        ];
        yield [
            'men3',
            'Ménages par sexe, âge et type d\'activité de la personne de référence âgée de 15 ans ou plus',
            $schemaName,
            'men3',
            'men3',
        ];
        yield [
            'men4',
            'Ménages par taille du ménage, sexe et âge de la personne de référence',
            $schemaName,
            'men4',
            'men4',
        ];
        yield [
            'men5',
            'Ménages par type de ménage et âge de la personne de référence',
            $schemaName,
            'men5',
            'men5',
        ];
        yield [
            'men6',
            'Population des ménages par type de ménage et âge de la personne de référence',
            $schemaName,
            'men6',
            'men6',
        ];
        yield [
            'men7',
            'Population des ménages par sexe, âge et mode de cohabitation',
            $schemaName,
            'men7',
            'men7',
        ];
    }
}
