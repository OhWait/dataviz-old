<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Insee\Menage;

use App\Fixtures\AbstractMetaRowFixture;

class MetaRowInseeMenFixture extends AbstractMetaRowFixture
{
    public function getDependencies(): array
    {
        return [
            MetaColumnInseeMenFixture::class,
        ];
    }

    /**
     * @see https://www.insee.fr/fr/statistiques/5395878?sommaire=5395927#dictionnaire
     */
    protected function getMeta(): \Generator
    {
        yield ['insee.men1.nivgeo', 'COM', 'Commune'];
        yield ['insee.men1.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.men2.nivgeo', 'COM', 'Commune'];
        yield ['insee.men2.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.men3.nivgeo', 'COM', 'Commune'];
        yield ['insee.men3.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.men4.nivgeo', 'COM', 'Commune'];
        yield ['insee.men4.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.men5.nivgeo', 'COM', 'Commune'];
        yield ['insee.men5.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.men6.nivgeo', 'COM', 'Commune'];
        yield ['insee.men6.nivgeo', 'ARM', 'Arrondissement'];
        yield ['insee.men7.nivgeo', 'COM', 'Commune'];
        yield ['insee.men7.nivgeo', 'ARM', 'Arrondissement'];

        for ($millesime = 2006; $millesime < 2021; ++$millesime) {
            yield ['insee.men1.millesime', $millesime, $millesime];
            yield ['insee.men2.millesime', $millesime, $millesime];
            yield ['insee.men3.millesime', $millesime, $millesime];
            yield ['insee.men4.millesime', $millesime, $millesime];
            yield ['insee.men5.millesime', $millesime, $millesime];
            yield ['insee.men6.millesime', $millesime, $millesime];
            yield ['insee.men7.millesime', $millesime, $millesime];
        }

        yield ['insee.men5.agemen7', '00', 'moins de 20 ans'];
        yield ['insee.men5.agemen7', '20', '20 à 24 ans'];
        yield ['insee.men5.agemen7', '25', '25 à 39 ans'];
        yield ['insee.men5.agemen7', '40', '40 à 54 ans'];
        yield ['insee.men5.agemen7', '55', '55 à 64 ans'];
        yield ['insee.men5.agemen7', '65', '65 à 79 ans'];
        yield ['insee.men5.agemen7', '80', '80 ans ou plus'];

        yield ['insee.men6.agemen7', '00', 'moins de 20 ans'];
        yield ['insee.men6.agemen7', '20', '20 à 24 ans'];
        yield ['insee.men6.agemen7', '25', '25 à 39 ans'];
        yield ['insee.men6.agemen7', '40', '40 à 54 ans'];
        yield ['insee.men6.agemen7', '55', '55 à 64 ans'];
        yield ['insee.men6.agemen7', '65', '65 à 79 ans'];
        yield ['insee.men6.agemen7', '80', '80 ans ou plus'];

        yield ['insee.men4.ageq20_80', '000', 'Moins de 20 ans'];
        for ($age = 20; $age < 80; $age += 5) {
            yield ['insee.men4.ageq20_80', sprintf("%'.03d", $age), sprintf('%d à %d ans', $age, $age + 4)];
        }
        yield ['insee.men4.ageq20_80', '080', '80 ans ou plus'];

        for ($age = 15; $age < 80; $age += 5) {
            yield ['insee.men3.ageq80_14', sprintf("%'.03d", $age), sprintf('%d à %d ans', $age, $age + 4)];
        }
        yield ['insee.men3.ageq80_14', '080', '80 ans ou plus'];

        yield ['insee.men7.ageq80_17', '000', 'Moins de 5 ans'];
        for ($age = 5; $age < 80; $age += 5) {
            yield ['insee.men7.ageq80_17', sprintf("%'.03d", $age), sprintf('%d à %d ans', $age, $age + 4)];
        }
        yield ['insee.men7.ageq80_17', '080', '80 ans ou plus'];

        yield ['insee.men1.cs2_24', '10', 'agriculteurs exploitants'];
        yield ['insee.men1.cs2_24', '21', 'artisans'];
        yield ['insee.men1.cs2_24', '22', 'commerçants et assimilés'];
        yield ['insee.men1.cs2_24', '23', 'chefs d\'entreprise de 10 salariés ou plus'];
        yield ['insee.men1.cs2_24', '31', 'professions libérales et assimilés'];
        yield ['insee.men1.cs2_24', '32', 'cadres de la fonction publique, professions intellectuelles et artistiques'];
        yield ['insee.men1.cs2_24', '36', 'cadres d\'entreprise'];
        yield ['insee.men1.cs2_24', '41', 'professions intermédiaires de l\'enseignement, de la santé, de la fonction publique et assimilés'];
        yield ['insee.men1.cs2_24', '46', 'professions intermédiaires administratives et commerciales des entreprises'];
        yield ['insee.men1.cs2_24', '47', 'techniciens'];
        yield ['insee.men1.cs2_24', '48', 'contremaîtres, agents de maîtrise'];
        yield ['insee.men1.cs2_24', '51', 'employés de la fonction publique'];
        yield ['insee.men1.cs2_24', '54', 'employés administratifs d\'entreprise'];
        yield ['insee.men1.cs2_24', '55', 'employés de commerce'];
        yield ['insee.men1.cs2_24', '56', 'personnels des services directs particuliers'];
        yield ['insee.men1.cs2_24', '61', 'ouvriers qualifiés'];
        yield ['insee.men1.cs2_24', '66', 'ouvriers non qualifiés'];
        yield ['insee.men1.cs2_24', '69', 'ouvriers agricoles'];
        yield ['insee.men1.cs2_24', '71', 'anciens agriculteurs exploitants'];
        yield ['insee.men1.cs2_24', '72', 'anciens artisans, commerçants, chefs d\'entreprise'];
        yield ['insee.men1.cs2_24', '73', 'anciens cadres et professions intermédiaires'];
        yield ['insee.men1.cs2_24', '76', 'anciens employés et ouvriers'];
        yield ['insee.men1.cs2_24', '81', 'chômeurs n\'ayant jamais travaillé'];
        yield ['insee.men1.cs2_24', '82', 'inactifs divers (autres que retraités)'];

        yield ['insee.men2.cs2_24', '10', 'agriculteurs exploitants'];
        yield ['insee.men2.cs2_24', '21', 'artisans'];
        yield ['insee.men2.cs2_24', '22', 'commerçants et assimilés'];
        yield ['insee.men2.cs2_24', '23', 'chefs d\'entreprise de 10 salariés ou plus'];
        yield ['insee.men2.cs2_24', '31', 'professions libérales et assimilés'];
        yield ['insee.men2.cs2_24', '32', 'cadres de la fonction publique, professions intellectuelles et artistiques'];
        yield ['insee.men2.cs2_24', '36', 'cadres d\'entreprise'];
        yield ['insee.men2.cs2_24', '41', 'professions intermédiaires de l\'enseignement, de la santé, de la fonction publique et assimilés'];
        yield ['insee.men2.cs2_24', '46', 'professions intermédiaires administratives et commerciales des entreprises'];
        yield ['insee.men2.cs2_24', '47', 'techniciens'];
        yield ['insee.men2.cs2_24', '48', 'contremaîtres, agents de maîtrise'];
        yield ['insee.men2.cs2_24', '51', 'employés de la fonction publique'];
        yield ['insee.men2.cs2_24', '54', 'employés administratifs d\'entreprise'];
        yield ['insee.men2.cs2_24', '55', 'employés de commerce'];
        yield ['insee.men2.cs2_24', '56', 'personnels des services directs particuliers'];
        yield ['insee.men2.cs2_24', '61', 'ouvriers qualifiés'];
        yield ['insee.men2.cs2_24', '66', 'ouvriers non qualifiés'];
        yield ['insee.men2.cs2_24', '69', 'ouvriers agricoles'];
        yield ['insee.men2.cs2_24', '71', 'anciens agriculteurs exploitants'];
        yield ['insee.men2.cs2_24', '72', 'anciens artisans, commerçants, chefs d\'entreprise'];
        yield ['insee.men2.cs2_24', '73', 'anciens cadres et professions intermédiaires'];
        yield ['insee.men2.cs2_24', '76', 'anciens employés et ouvriers'];
        yield ['insee.men2.cs2_24', '81', 'chômeurs n\'ayant jamais travaillé'];
        yield ['insee.men2.cs2_24', '82', 'inactifs divers (autres que retraités)'];

        yield ['insee.men7.moco', '11', 'enfants d\'un couple'];
        yield ['insee.men7.moco', '12', 'enfants d\'une famille monoparentale'];
        yield ['insee.men7.moco', '21', 'adultes d\'un couple sans enfant'];
        yield ['insee.men7.moco', '22', 'adultes d\'un couple avec enfant'];
        yield ['insee.men7.moco', '23', 'adultes d\'une famille monoparentale'];
        yield ['insee.men7.moco', '31', 'hors famille dans ménage de plusieurs personnes'];
        yield ['insee.men7.moco', '32', 'personnes vivant seules'];

        yield ['insee.men1.nperc', '1', '1 personne'];
        yield ['insee.men1.nperc', '2', '2 personnes'];
        yield ['insee.men1.nperc', '3', '3 personnes'];
        yield ['insee.men1.nperc', '4', '4 personnes'];
        yield ['insee.men1.nperc', '5', '5 personnes'];
        yield ['insee.men1.nperc', '6', '6 personnes ou plus'];

        yield ['insee.men2.nperc', '1', '1 personne'];
        yield ['insee.men2.nperc', '2', '2 personnes'];
        yield ['insee.men2.nperc', '3', '3 personnes'];
        yield ['insee.men2.nperc', '4', '4 personnes'];
        yield ['insee.men2.nperc', '5', '5 personnes'];
        yield ['insee.men2.nperc', '6', '6 personnes ou plus'];

        yield ['insee.men4.nperc', '1', '1 personne'];
        yield ['insee.men4.nperc', '2', '2 personnes'];
        yield ['insee.men4.nperc', '3', '3 personnes'];
        yield ['insee.men4.nperc', '4', '4 personnes'];
        yield ['insee.men4.nperc', '5', '5 personnes'];
        yield ['insee.men4.nperc', '6', '6 personnes ou plus'];

        yield ['insee.men3.sexe', '1', 'Hommes'];
        yield ['insee.men3.sexe', '2', 'Femmes'];

        yield ['insee.men4.sexe', '1', 'Hommes'];
        yield ['insee.men4.sexe', '2', 'Femmes'];

        yield ['insee.men7.sexe', '1', 'Hommes'];
        yield ['insee.men7.sexe', '2', 'Femmes'];

        yield ['insee.men3.tactr', '11', 'actifs ayant un emploi'];
        yield ['insee.men3.tactr', '12', 'chômeurs'];
        yield ['insee.men3.tactr', '21', 'retraités ou préretraités'];
        yield ['insee.men3.tactr', '22', 'élèves, étudiants, stagiaires non rémunérés'];
        yield ['insee.men3.tactr', '24', 'femmes ou hommes au foyer'];
        yield ['insee.men3.tactr', '26', 'autres inactifs'];

        yield ['insee.men5.typmr', '11', 'Homme vivant seul'];
        yield ['insee.men5.typmr', '12', 'Femme vivant seule'];
        yield ['insee.men5.typmr', '20', 'Plusieurs personnes sans famille'];
        yield ['insee.men5.typmr', '31', 'Famille principale monoparentale composée d\'un homme avec enfant(s)'];
        yield ['insee.men5.typmr', '32', 'Famille principale monoparentale composée d\'une femme avec enfant(s)'];
        yield ['insee.men5.typmr', '41', 'Famille principale composée d\'un couple de deux "actifs ayant un emploi"'];
        yield ['insee.men5.typmr', '42', 'Famille principale composée d\'un couple où seul un homme a le statut "d\'actif ayant un emploi"'];
        yield ['insee.men5.typmr', '43', 'Famille principale composée d\'un couple où seule une femme a le statut "d\'actif ayant un emploi"'];
        yield ['insee.men5.typmr', '44', 'Famille principale composée d\'un couple d\'aucun "actif ayant un emploi"'];
        yield ['insee.men5.typmr', 'ZZ', 'Hors logement ordinaire'];

        yield ['insee.men6.typmr', '11', 'Homme vivant seul'];
        yield ['insee.men6.typmr', '12', 'Femme vivant seule'];
        yield ['insee.men6.typmr', '20', 'Plusieurs personnes sans famille'];
        yield ['insee.men6.typmr', '31', 'Famille principale monoparentale composée d\'un homme avec enfant(s)'];
        yield ['insee.men6.typmr', '32', 'Famille principale monoparentale composée d\'une femme avec enfant(s)'];
        yield ['insee.men6.typmr', '41', 'Famille principale composée d\'un couple de deux "actifs ayant un emploi"'];
        yield ['insee.men6.typmr', '42', 'Famille principale composée d\'un couple où seul un homme a le statut "d\'actif ayant un emploi"'];
        yield ['insee.men6.typmr', '43', 'Famille principale composée d\'un couple où seule une femme a le statut "d\'actif ayant un emploi"'];
        yield ['insee.men6.typmr', '44', 'Famille principale composée d\'un couple d\'aucun "actif ayant un emploi"'];
        yield ['insee.men6.typmr', 'ZZ', 'Hors logement ordinaire'];
    }
}
