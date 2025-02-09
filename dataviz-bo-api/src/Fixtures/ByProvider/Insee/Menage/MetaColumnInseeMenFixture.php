<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Insee\Menage;

use App\Enum\MetaColumn\DataTypeEnum;
use App\Fixtures\AbstractMetaColumnFixture;

class MetaColumnInseeMenFixture extends AbstractMetaColumnFixture
{
    public function getDependencies(): array
    {
        return [
            DataEntryInseeMenFixture::class,
        ];
    }

    /**
     * @see https://www.insee.fr/fr/statistiques/5395878?sommaire=5395927#dictionnaire
     */
    protected function getMeta(): \Generator
    {
        yield ['insee.men1', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men1', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men1', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men1', 'cs2_24', 'Catégorie socioprofessionnelle détaillée (24 postes)', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men1', 'nperc', 'Nombre de personnes du ménage', false, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['insee.men1', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];

        yield ['insee.men2', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men2', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men2', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men2', 'cs2_24', 'Catégorie socioprofessionnelle détaillée (24 postes)', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men2', 'nperc', 'Nombre de personnes du ménage', false, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['insee.men2', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];

        yield ['insee.men3', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men3', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men3', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men3', 'tactr', 'Type d\'activité', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men3', 'ageq80_14', 'Âge quinquennal', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men3', 'sexe', 'Sexe', false, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['insee.men3', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];

        yield ['insee.men4', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men4', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men4', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men4', 'sexe', 'Sexe', false, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['insee.men4', 'ageq20_80', ' Âge quinquennal', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men4', 'nperc', 'Nombre de personnes du ménage', false, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['insee.men4', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];

        yield ['insee.men5', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men5', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men5', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men5', 'typmr', 'Type de ménage regroupé (en 9 postes)', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men5', 'agemen7', 'Âge regroupé (7 classes d\'âges)', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men5', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];

        yield ['insee.men6', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men6', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men6', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men6', 'typmr', 'Type de ménage regroupé (en 9 postes)', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men6', 'agemen7', 'Âge regroupé (7 classes d\'âges)', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men6', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];

        yield ['insee.men7', 'millesime', 'Millésime', false, DataTypeEnum::INTEGER->value, null];
        yield ['insee.men7', 'nivgeo', 'Niveau géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men7', 'codgeo', 'Code géographique', false, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['insee.men7', 'moco', 'Mode de cohabitation', false, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['insee.men7', 'ageq80_17', 'Âge quinquennal', false, DataTypeEnum::CHARACTER_VARYING->value, 3];
        yield ['insee.men7', 'sexe', 'Sexe', false, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['insee.men7', 'nb', 'Nombre', false, DataTypeEnum::NUMERIC->value, null];
    }
}
