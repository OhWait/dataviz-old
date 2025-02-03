<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures\ByProvider\Insee\Population;

use App\Infrastructure\Fixtures\AbstractMetaColumnFixture;

class MetaColumnInseePopFixture extends AbstractMetaColumnFixture
{
    public function getDependencies()
    {
        return [
            DataEntryInseePopFixture::class,
        ];
    }

    /**
     * @see https://www.insee.fr/fr/statistiques/5395878?sommaire=5395927#dictionnaire
     */
    protected function getMeta(): \Generator
    {
        yield ['insee.pop1a', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop1a', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop1a', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop1a', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop1a', 'agepyr10', 'Âge regroupé (10 classes d\'âges)', false, 'character varying', 2];
        yield ['insee.pop1a', 'nb', 'Nombre', false, 'numeric'];

        yield ['insee.pop1b', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop1b', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop1b', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop1b', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop1b', 'aged100', 'Âge détaillé', false, 'character varying', 3];
        yield ['insee.pop1b', 'nb', 'Nombre', false, 'numeric'];

        yield ['insee.pop2', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop2', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop2', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop2', 'ageq100', 'Âge détaillé', false, 'character varying', 3];
        yield ['insee.pop2', 'catpr', 'Catégorie de population', false, 'character varying', 2];
        yield ['insee.pop2', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop2', 'nb', 'Nombre', false, 'numeric'];

        yield ['insee.pop3', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop3', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop3', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop3', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop3', 'ageq80_14', 'Âge quinquennal', false, 'character varying', 3];
        yield ['insee.pop3', 'matr', 'État matrimonial légal', false, 'character varying', 1];
        yield ['insee.pop3', 'stat_conj', 'Statut conjugal', false, 'character varying', 1];
        yield ['insee.pop3', 'stat_conj_19', 'Statut conjugal', false, 'character varying', 1];
        yield ['insee.pop3', 'nb', 'Nombre', false, 'numeric'];

        yield ['insee.pop4', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop4', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop4', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop4', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop4', 'couple', 'Vie en couple', false, 'character varying', 3];
        yield ['insee.pop4', 'nb', 'Nombre', false, 'numeric'];

        yield ['insee.pop5', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop5', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop5', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop5', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop5', 'ageq65', 'Âge quinquennal', false, 'character varying', 3];
        yield ['insee.pop5', 'tactr', 'Type d\'activité', false, 'character varying', 2];
        yield ['insee.pop5', 'nb', 'Nombre', false, 'numeric'];

        yield ['insee.pop6', 'millesime', 'Millésime', false, 'integer'];
        yield ['insee.pop6', 'nivgeo', 'Niveau géographique', false, 'character varying', 3];
        yield ['insee.pop6', 'codgeo', 'Code géographique', false, 'character varying', 5];
        yield ['insee.pop6', 'cs1_8', 'Catégorie socioprofessionnelle regroupée (8 postes)', false, 'character varying', 1];
        yield ['insee.pop6', 'ageq65', 'Âge quinquennal', false, 'character varying', 3];
        yield ['insee.pop6', 'sexe', 'Sexe', false, 'character varying', 1];
        yield ['insee.pop6', 'nb', 'Nombre', false, 'numeric'];
    }
}
