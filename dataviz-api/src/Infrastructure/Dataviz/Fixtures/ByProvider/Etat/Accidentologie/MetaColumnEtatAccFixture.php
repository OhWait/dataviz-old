<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures\ByProvider\Etat\Accidentologie;

use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Infrastructure\Dataviz\Fixtures\AbstractMetaColumnFixture;

class MetaColumnEtatAccFixture extends AbstractMetaColumnFixture
{
    public function getDependencies()
    {
        return [
            DataEntryEtatAccFixture::class,
        ];
    }

    /**
     * @see https://www.insee.fr/fr/statistiques/5395878?sommaire=5395927#dictionnaire
     */
    protected function getMeta(): \Generator
    {
        yield ['etat.acc_caracteristique', 'num_acc', 'Numéro d\'identifiant de l\'accident', false, DataTypeEnum::CHARACTER_VARYING->value];
        yield ['etat.acc_caracteristique', 'date', 'Date de l\'accident', false, DataTypeEnum::TIME_WNTZ->value];
        yield ['etat.acc_caracteristique', 'lum',  'Lumière : conditions d\'éclairage dans lesquelles l\'accident s\'est produit', true, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['etat.acc_caracteristique', 'codgeo', 'Commune : Le numéro de commune est un code donné par l\'INSEE', true, DataTypeEnum::CHARACTER_VARYING->value, 5];
        yield ['etat.acc_caracteristique', 'agg', 'Localisation', true, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['etat.acc_caracteristique', 'inter', 'Intersection', true, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['etat.acc_caracteristique', 'atm', 'Conditions atmosphériques', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_caracteristique', 'col', 'Type de collision', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_caracteristique', 'address', 'Adressse postale: variable renseignée pour les accidents survenus en agglomération.', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_caracteristique', 'lat', 'Latitude', true, DataTypeEnum::NUMERIC->value];
        yield ['etat.acc_caracteristique', 'lng', 'Longitude', true, DataTypeEnum::NUMERIC->value];

        yield ['etat.acc_lieu', 'num_acc', 'Numéro d\'identifiant de l\'accident', false, DataTypeEnum::CHARACTER_VARYING->value];
        yield ['etat.acc_lieu', 'catr', 'Catégorie de route', true, DataTypeEnum::CHARACTER_VARYING->value, 1];
        yield ['etat.acc_lieu', 'voie', 'Numéro de la route', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'v1', 'Indice numérique du numéro de route', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'v2', 'Lettre indice alphanumérique de la route', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'circ', 'Régime de circulation', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'nbv', 'Nombre total de voies de circulation', true, DataTypeEnum::INTEGER->value];
        yield ['etat.acc_lieu', 'vosp', 'Signale l\'existence d\'une voie réservée, indépendamment du fait que l\'accident ait lieu ou non sur cette voie', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'prof', 'Profil en long décrit la déclivité de la route à l\'endroit de l\'accident', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'pr', 'Numéro du PR de rattachement (numéro de la borne amont).', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'pr1', 'Distance en mètres au PR (par rapport à la borne amont).', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'plan', 'Tracé en plan', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'lartpc', 'Largeur du terre-plein central (TPC) s\'il existe (en m)', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'larrout', 'Largeur de la chaussée affectée à la circulation des véhicules ne sont pas compris les bandes d\'arrêt d\'urgence, les TPC et les places de stationnement (en m)', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_lieu', 'surf', 'État de la surface', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'infra', 'Aménagement - Infrastructure', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'situ', 'Situation de l\'accident', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_lieu', 'vma', 'Vitesse maximale autorisée sur le lieu et au moment de l\'accident', true, DataTypeEnum::INTEGER->value];

        yield ['etat.acc_vehicule', 'num_acc', 'Numéro d\'identifiant de l\'accident', false, DataTypeEnum::CHARACTER_VARYING->value];
        yield ['etat.acc_vehicule', 'id_vehicule', 'Identifiant unique du véhicule repris pour chacun des usagers occupant ce véhicule (y compris les piétons qui sont rattachés aux véhicules qui les ont heurtés) - Code numérique', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_vehicule', 'num_veh', 'Identifiant du véhicule repris pour chacun des usagers occupant ce véhicule (y compris les piétons qui sont rattachés aux véhicules qui les ont heurtés) - Code alphanumérique', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_vehicule', 'senc', 'Sens de circulation', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'catv', 'Catégorie du véhicule', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'obs', 'Obstacle fixe heurté', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'obsm', 'Obstacle mobile heurté', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'choc', 'Point de choc initial', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'manv', 'Manoeuvre principale avant l\'accident', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'motor', 'Type de motorisation du véhicule', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_vehicule', 'occutc', 'Nombre d\'occupants dans le transport en commun', true, DataTypeEnum::INTEGER->value];

        yield ['etat.acc_usager', 'num_acc', 'Numéro d\'identifiant de l\'accident', false, DataTypeEnum::CHARACTER_VARYING->value];
        yield ['etat.acc_usager', 'id_usager', 'Identifiant unique de l\'usager (y compris les piétons qui sont rattachés aux véhicules qui les ont heurtés) - Code numérique', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_usager', 'id_vehicule', 'Identifiant unique du véhicule repris pour chacun des usagers occupant ce véhicule (y compris les piétons qui sont rattachés aux véhicules qui les ont heurtés) - Code numérique', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_usager', 'num_vehicule', 'Identifiant du véhicule repris pour chacun des usagers occupant ce véhicule (y compris les piétons qui sont rattachés aux véhicules qui les ont heurtés) - Code alphanumérique', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_usager', 'place', 'Permet de situer la place occupée dans le véhicule par l\'usager au moment de l\'accident. Le détail est donné par l\'illustration ci-dessous', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_usager', 'catu', 'Catégorie d\'usager', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'grav', 'Gravité de blessure de l\'usager, les usagers accidentés sont classés en trois catégories de victimes plus les indemnes', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'sexe', 'Sexe de l\'usager', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'an_nais', 'Année de naissance de l\'usager', true, DataTypeEnum::INTEGER->value];
        yield ['etat.acc_usager', 'trajet', 'Motif du déplacement au moment de l\'accident', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'secu', 'TO UPDATE', true, DataTypeEnum::CHARACTER_VARYING->value, 255];
        yield ['etat.acc_usager', 'secu1', 'Le renseignement du caractère indique la présence et l\'utilisation de l\'équipement de sécurité', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'secu2', 'Le renseignement du caractère indique la présence et l\'utilisation de l\'équipement de sécurité', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'secu3', 'Le renseignement du caractère indique la présence et l\'utilisation de l\'équipement de sécurité', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'locp', 'Localisation du piéton', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'actp', 'Action du piéton', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
        yield ['etat.acc_usager', 'etatp', 'Accompagnement piéton', true, DataTypeEnum::CHARACTER_VARYING->value, 2];
    }
}
