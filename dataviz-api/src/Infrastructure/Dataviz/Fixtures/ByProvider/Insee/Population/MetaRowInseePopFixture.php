<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures\ByProvider\Insee\Population;

use App\Infrastructure\Dataviz\Fixtures\AbstractMetaRowFixture;

class MetaRowInseePopFixture extends AbstractMetaRowFixture
{
    public function getDependencies()
    {
        return [
            MetaColumnInseePopFixture::class,
        ];
    }

    /**
     * @see https://www.insee.fr/fr/statistiques/5395878?sommaire=5395927#dictionnaire
     */
    protected function getMeta(): \Generator
    {
        yield ['insee.pop1a.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop1a.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.pop1b.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop1b.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.pop2.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop2.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.pop3.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop3.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.pop4.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop4.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.pop5.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop5.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.pop6.nivgeo', 'COM', 'Commune'];
        yield ['insee.pop6.nivgeo', 'ARM', 'Arrondissement'];

        for ($millesime = 2006; $millesime < 2021; ++$millesime) {
            yield ['insee.pop1a.millesime', $millesime, $millesime];
            yield ['insee.pop1b.millesime', $millesime, $millesime];
            yield ['insee.pop2.millesime', $millesime, $millesime];
            yield ['insee.pop3.millesime', $millesime, $millesime];
            yield ['insee.pop4.millesime', $millesime, $millesime];
            yield ['insee.pop5.millesime', $millesime, $millesime];
            yield ['insee.pop6.millesime', $millesime, $millesime];
        }

        yield ['insee.pop1b.aged100', '000', 'Moins d\'un an'];
        yield ['insee.pop1b.aged100', '001', '1 an'];
        for ($age = 2; $age < 100; ++$age) {
            $aged100 = $age < 10 ? "00{$age}" : "0{$age}";
            yield ['insee.pop1b.aged100', $aged100, "{$age} ans"];
        }
        yield ['insee.pop1b.aged100', '100', '100 ans ou plus'];

        yield ['insee.pop1a.agepyr10', '00', 'moins de 3 ans'];
        yield ['insee.pop1a.agepyr10', '03', '3 à 5 ans'];
        yield ['insee.pop1a.agepyr10', '06', '6 à 10 ans'];
        yield ['insee.pop1a.agepyr10', '11', '11 à 17 ans'];
        yield ['insee.pop1a.agepyr10', '18', '18 à 24 ans'];
        yield ['insee.pop1a.agepyr10', '25', '25 à 39 ans'];
        yield ['insee.pop1a.agepyr10', '40', '40 à 54 ans'];
        yield ['insee.pop1a.agepyr10', '55', '55 à 64 ans'];
        yield ['insee.pop1a.agepyr10', '65', '65 à 79 ans'];
        yield ['insee.pop1a.agepyr10', '80', '80 ans ou plus'];

        for ($ageq65 = 15; $ageq65 < 65; $ageq65 += 5) {
            $ageq65p4 = $ageq65 + 4;
            yield ['insee.pop5.ageq65', "0{$ageq65}", "{$ageq65} à {$ageq65p4} ans"];
            yield ['insee.pop6.ageq65', "0{$ageq65}", "{$ageq65} à {$ageq65p4} ans"];
        }
        yield ['insee.pop5.ageq65', '065', '65 ans ou plus'];
        yield ['insee.pop6.ageq65', '065', '65 ans ou plus'];

        for ($ageq80_14 = 15; $ageq80_14 < 80; $ageq80_14 += 5) {
            $ageq80_14p4 = $ageq80_14 + 4;
            yield ['insee.pop3.ageq80_14', "0{$ageq80_14}", "{$ageq80_14} à {$ageq80_14p4} ans"];
        }
        yield ['insee.pop3.ageq80_14', '080', '80 ans ou plus'];

        yield ['insee.pop2.ageq100', '000', 'Moins de 5 ans'];
        yield ['insee.pop2.ageq100', '005', '5 à 9 ans'];
        for ($ageq100 = 10; $ageq100 < 100; $ageq100 += 5) {
            $ageq100p4 = $ageq100 + 4;
            yield ['insee.pop2.ageq100', "0{$ageq100}", "{$ageq100} à {$ageq100p4} ans"];
        }
        yield ['insee.pop2.ageq100', '100', '100 ans ou plus'];

        yield ['insee.pop2.catpr', '01', 'Individus en logement ordinaire'];
        yield ['insee.pop2.catpr', '11', 'Individus dans un service ou établissement de moyen ou long séjour, maison de retraite, foyer ou résidence sociale'];
        yield ['insee.pop2.catpr', '12', 'Membres d\'une communauté religieuse'];
        yield ['insee.pop2.catpr', '13', 'Individus en caserne, quartier, base ou camp militaire'];
        yield ['insee.pop2.catpr', '14', 'Individus résidant dans un établissement hébergeant des élèves ou des étudiants'];
        yield ['insee.pop2.catpr', '16', 'Individus en établissement social de court séjour'];
        yield ['insee.pop2.catpr', '21', 'Individus en habitation mobile, mariniers, sans-abri'];
        yield ['insee.pop2.catpr', '30', 'Individus résidant dans une autre catégorie de communauté'];

        yield ['insee.pop4.couple', '1', 'Vivant en couple'];
        yield ['insee.pop4.couple', '2', 'Ne vivant pas en couple'];

        yield ['insee.pop6.cs1_8', '1', 'agriculteurs exploitants'];
        yield ['insee.pop6.cs1_8', '2', 'artisans, commerçants, chefs entreprise'];
        yield ['insee.pop6.cs1_8', '3', 'cadres et professions intellectuelles supérieures'];
        yield ['insee.pop6.cs1_8', '4', 'professions intermédiaires'];
        yield ['insee.pop6.cs1_8', '5', 'employés'];
        yield ['insee.pop6.cs1_8', '6', 'ouvriers'];
        yield ['insee.pop6.cs1_8', '7', 'retraités'];
        yield ['insee.pop6.cs1_8', '8', 'autres personnes sans activité professionnelle'];

        yield ['insee.pop1a.sexe', '1', 'Homme'];
        yield ['insee.pop1a.sexe', '2', 'Femme'];
        yield ['insee.pop1b.sexe', '1', 'Homme'];
        yield ['insee.pop1b.sexe', '2', 'Femme'];
        yield ['insee.pop2.sexe', '1', 'Homme'];
        yield ['insee.pop2.sexe', '2', 'Femme'];
        yield ['insee.pop3.sexe', '1', 'Homme'];
        yield ['insee.pop3.sexe', '2', 'Femme'];
        yield ['insee.pop4.sexe', '1', 'Homme'];
        yield ['insee.pop4.sexe', '2', 'Femme'];
        yield ['insee.pop5.sexe', '1', 'Homme'];
        yield ['insee.pop5.sexe', '2', 'Femme'];
        yield ['insee.pop6.sexe', '1', 'Homme'];
        yield ['insee.pop6.sexe', '2', 'Femme'];

        yield ['insee.pop3.matr', '1', 'Célibataires'];
        yield ['insee.pop3.matr', '2', 'Marié(e)s'];
        yield ['insee.pop3.matr', '3', 'Veufs, veuves'];
        yield ['insee.pop3.matr', '4', 'Divorcé(e)s'];

        yield ['insee.pop3.stat_conj', 'A', 'Marié(e)'];
        yield ['insee.pop3.stat_conj', 'B', 'Non marié(e)'];

        yield ['insee.pop3.stat_conj_19', '1', 'Marié(e)'];
        yield ['insee.pop3.stat_conj_19', '2', 'Pacsé(e)'];
        yield ['insee.pop3.stat_conj_19', '3', 'Concubinage ou union libre'];
        yield ['insee.pop3.stat_conj_19', '4', 'Veuf (veuve)'];
        yield ['insee.pop3.stat_conj_19', '5', 'Divorcé(e)'];
        yield ['insee.pop3.stat_conj_19', '6', 'Célibataire'];

        yield ['insee.pop5.tactr', '11', 'actifs ayant un emploi'];
        yield ['insee.pop5.tactr', '12', 'chômeurs'];
        yield ['insee.pop5.tactr', '21', 'retraités ou préretraités'];
        yield ['insee.pop5.tactr', '22', 'élèves, étudiants, stagiaires non rémunérés'];
        yield ['insee.pop5.tactr', '24', 'femmes ou hommes au foyer'];
        yield ['insee.pop5.tactr', '26', 'autres inactifs'];
    }
}
