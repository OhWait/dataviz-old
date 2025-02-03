<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures\ByProvider\Insee\Population;

use App\Infrastructure\Dataviz\Fixtures\AbstractDataEntryFixture;

class DataEntryInseePopFixture extends AbstractDataEntryFixture
{
    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            DatasetInseePopFixture::class,
        ];
    }

    protected function getDataEntries(): \Generator
    {
        $schemaName = 'insee';

        yield [
            'pop1a',
            'Population par sexe et âge regroupé',
            $schemaName,
            'pop1a',
            'pop1a',
        ];
        yield [
            'pop1b',
            'Population par sexe et âge',
            $schemaName,
            'pop1b',
            'pop1b',
        ];
        yield [
            'pop2',
            'Population par sexe, âge et catégorie de population',
            $schemaName,
            'pop2',
            'pop2',
        ];
        yield [
            'pop3',
            'Population de 15 ans ou plus par sexe, âge et statut conjugal',
            $schemaName,
            'pop3',
            'pop3',
        ];
        yield [
            'pop4',
            'Population de 15 ans ou plus par sexe, âge et vie en couple',
            $schemaName,
            'pop4',
            'pop4',
        ];
        yield [
            'pop5',
            'Population de 15 ans ou plus par sexe, âge et type d\'activité',
            $schemaName,
            'pop5',
            'pop5',
        ];
        yield [
            'pop6',
            'Population de 15 ans ou plus par sexe, âge et catégorie socioprofessionnelle',
            $schemaName,
            'pop6',
            'pop6',
        ];
    }
}
