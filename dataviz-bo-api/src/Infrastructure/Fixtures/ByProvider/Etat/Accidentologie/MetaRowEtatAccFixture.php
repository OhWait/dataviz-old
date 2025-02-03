<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures\ByProvider\Etat\Accidentologie;

use App\Infrastructure\Fixtures\AbstractMetaRowFixture;

class MetaRowEtatAccFixture extends AbstractMetaRowFixture
{
    public function getDependencies()
    {
        return [
            MetaColumnEtatAccFixture::class,
        ];
    }

    protected function getMeta(): \Generator
    {
        // CARACTERISTIQUE
        yield ['etat.acc_caracteristique.lum', '1', 'Plein jour'];
        yield ['etat.acc_caracteristique.lum', '2', 'Crépuscule ou aube'];
        yield ['etat.acc_caracteristique.lum', '3', 'Nuit sans éclairage public'];
        yield ['etat.acc_caracteristique.lum', '4', 'Nuit avec éclairage public non allumé'];
        yield ['etat.acc_caracteristique.lum', '5', 'Nuit avec éclaire public allumé'];

        yield ['etat.acc_caracteristique.agg', '1', 'Hors agglomération'];
        yield ['etat.acc_caracteristique.agg', '2', 'En agglomération'];

        yield ['etat.acc_caracteristique.inter', '1', 'Hors intersection'];
        yield ['etat.acc_caracteristique.inter', '2', 'Intersection en X'];
        yield ['etat.acc_caracteristique.inter', '3', 'Intersection en T'];
        yield ['etat.acc_caracteristique.inter', '4', 'Intersection en Y'];
        yield ['etat.acc_caracteristique.inter', '5', 'Intersection à plus de 4 branches'];
        yield ['etat.acc_caracteristique.inter', '6', 'Giratoire'];
        yield ['etat.acc_caracteristique.inter', '7', 'Place'];
        yield ['etat.acc_caracteristique.inter', '8', 'Passage à niveau'];
        yield ['etat.acc_caracteristique.inter', '9', 'Autre intersection'];

        yield ['etat.acc_caracteristique.col', '-1', 'Non renseigné'];
        yield ['etat.acc_caracteristique.col', '1', 'Deux véhicules - frontale'];
        yield ['etat.acc_caracteristique.col', '2', 'Deux véhicules - par l\'arrière'];
        yield ['etat.acc_caracteristique.col', '3', 'Deux véhicules - par le côté'];
        yield ['etat.acc_caracteristique.col', '4', 'Trois véhicules et plus - en chaîne'];
        yield ['etat.acc_caracteristique.col', '5', 'Trois véhicules et plus - collisions multiples'];
        yield ['etat.acc_caracteristique.col', '6', 'Autre collision'];
        yield ['etat.acc_caracteristique.col', '7', 'Sans collision'];

        // LIEU
        yield ['etat.acc_lieu.catr', '1', 'Autoroute'];
        yield ['etat.acc_lieu.catr', '2', 'Route nationale'];
        yield ['etat.acc_lieu.catr', '3', 'Route Départementale'];
        yield ['etat.acc_lieu.catr', '4', 'Voie Communales'];
        yield ['etat.acc_lieu.catr', '5', 'Hors réseau public'];
        yield ['etat.acc_lieu.catr', '6', 'Parc de stationnement ouvert à la circulation publique'];
        yield ['etat.acc_lieu.catr', '7', 'Routes de métropole urbaine'];
        yield ['etat.acc_lieu.catr', '9', 'Autre'];

        yield ['etat.acc_lieu.circ', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.circ', '1', 'A sens unique'];
        yield ['etat.acc_lieu.circ', '2', 'Bidirectionnelle'];
        yield ['etat.acc_lieu.circ', '3', 'A chaussées séparées'];
        yield ['etat.acc_lieu.circ', '4', 'Avec voies d\'affectation variable'];

        yield ['etat.acc_lieu.vosp', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.vosp', '0', 'Sans objet'];
        yield ['etat.acc_lieu.vosp', '1', 'Piste cyclable'];
        yield ['etat.acc_lieu.vosp', '2', 'Bande cyclable'];
        yield ['etat.acc_lieu.vosp', '3', 'Voie réservée'];

        yield ['etat.acc_lieu.prof', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.prof', '1', 'Plat'];
        yield ['etat.acc_lieu.prof', '2', 'Pente'];
        yield ['etat.acc_lieu.prof', '3', 'Sommet de côté'];
        yield ['etat.acc_lieu.prof', '4', 'Bas de côte'];

        yield ['etat.acc_lieu.plan', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.plan', '1', 'Partie rectiligne'];
        yield ['etat.acc_lieu.plan', '2', 'En courbe à gauche'];
        yield ['etat.acc_lieu.plan', '3', 'En courbe à droite'];
        yield ['etat.acc_lieu.plan', '4', 'En S'];

        yield ['etat.acc_lieu.surf', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.surf', '1', 'Normale'];
        yield ['etat.acc_lieu.surf', '2', 'Mouillée'];
        yield ['etat.acc_lieu.surf', '3', 'Flaques'];
        yield ['etat.acc_lieu.surf', '4', 'Innondée'];
        yield ['etat.acc_lieu.surf', '5', 'Enneigée'];
        yield ['etat.acc_lieu.surf', '6', 'Boue'];
        yield ['etat.acc_lieu.surf', '7', 'Verglacée'];
        yield ['etat.acc_lieu.surf', '8', 'Corps gras - huile'];
        yield ['etat.acc_lieu.surf', '9', 'Autre'];

        yield ['etat.acc_lieu.infra', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.infra', '0', 'Aucun'];
        yield ['etat.acc_lieu.infra', '1', 'Souterrain - tunnel'];
        yield ['etat.acc_lieu.infra', '2', 'Pont - autopont'];
        yield ['etat.acc_lieu.infra', '3', 'Bretelle d\'échangeur ou de raccordement'];
        yield ['etat.acc_lieu.infra', '4', 'Voie ferrée'];
        yield ['etat.acc_lieu.infra', '5', 'Carrefour aménagé'];
        yield ['etat.acc_lieu.infra', '6', 'Zone piétonne'];
        yield ['etat.acc_lieu.infra', '7', 'Zone de péage'];
        yield ['etat.acc_lieu.infra', '8', 'Chantier'];
        yield ['etat.acc_lieu.infra', '9', 'Autres'];

        yield ['etat.acc_lieu.situ', '-1', 'Non renseigné'];
        yield ['etat.acc_lieu.situ', '0', 'Aucun'];
        yield ['etat.acc_lieu.situ', '1', 'Sur chaussée'];
        yield ['etat.acc_lieu.situ', '2', 'Sur bande d\'arrêt d\'urgence'];
        yield ['etat.acc_lieu.situ', '3', 'Sur accotement'];
        yield ['etat.acc_lieu.situ', '4', 'Sur trottoir'];
        yield ['etat.acc_lieu.situ', '5', 'Sur piste cyclable'];
        yield ['etat.acc_lieu.situ', '6', 'Sur autre voie spéciale'];
        yield ['etat.acc_lieu.situ', '8', 'Autres'];

        // VEHICULE
        yield ['etat.acc_vehicule.senc', '-1', 'Non renseigné'];
        yield ['etat.acc_vehicule.senc', '0', 'Inconnu'];
        yield ['etat.acc_vehicule.senc', '1', 'PK ou PR ou numéro d\'adresse postale croissant '];
        yield ['etat.acc_vehicule.senc', '2', 'PK ou PR ou numéro d\'adresse postale décroissant'];
        yield ['etat.acc_vehicule.senc', '3', 'Absence de repère '];

        yield ['etat.acc_vehicule.catv', '-1', 'Non renseigné'];
        yield ['etat.acc_vehicule.catv', '00', 'Indéterminable'];
        yield ['etat.acc_vehicule.catv', '01', 'Bicyclette'];
        yield ['etat.acc_vehicule.catv', '02', 'Cyclomoteur < 50cm3 '];
        yield ['etat.acc_vehicule.catv', '03', 'Voiturette (Quadricycle à moteur carrossé) (anciennement "voiturette ou tricycle à moteur")'];
        yield ['etat.acc_vehicule.catv', '04', 'Référence inutilisée depuis 2006 (scooter immatriculé)'];
        yield ['etat.acc_vehicule.catv', '05', 'Référence inutilisée depuis 2006 (motocyclette)'];
        yield ['etat.acc_vehicule.catv', '06', 'Référence inutilisée depuis 2006 (side-car)'];
        yield ['etat.acc_vehicule.catv', '07', 'VL seul'];
        yield ['etat.acc_vehicule.catv', '08', 'Référence inutilisée depuis 2006 (VL + caravane)'];
        yield ['etat.acc_vehicule.catv', '09', 'Référence inutilisée depuis 2006 (VL + remorque)'];
        yield ['etat.acc_vehicule.catv', '10', 'VU seul 1,5T <= PTAC <= 3,5T avec ou sans remorque (anciennement VU seul 1,5T <= PTAC <= 3,5T)'];
        yield ['etat.acc_vehicule.catv', '11', 'Référence inutilisée depuis 2006 (VU (10) + caravane)'];
        yield ['etat.acc_vehicule.catv', '12', 'Référence inutilisée depuis 2006 (VU (10) + remorque)'];
        yield ['etat.acc_vehicule.catv', '13', 'PL seul 3,5T < PTCA <= 7,5T'];
        yield ['etat.acc_vehicule.catv', '14', 'PL seul > 7,5T '];
        yield ['etat.acc_vehicule.catv', '15', 'PL > 3,5T + remorque'];
        yield ['etat.acc_vehicule.catv', '16', 'Tracteur routier seul'];
        yield ['etat.acc_vehicule.catv', '17', 'Tracteur routier + semi-remorque'];
        yield ['etat.acc_vehicule.catv', '18', 'Référence inutilisée depuis 2006 (transport en commun)'];
        yield ['etat.acc_vehicule.catv', '19', 'Référence inutilisée depuis 2006 (tramway)'];
        yield ['etat.acc_vehicule.catv', '20', 'Engin spécial '];
        yield ['etat.acc_vehicule.catv', '21', 'Tracteur agricole '];
        yield ['etat.acc_vehicule.catv', '30', 'Scooter < 50 cm3'];
        yield ['etat.acc_vehicule.catv', '31', 'Motocyclette > 50 cm3 et <= 125 cm3'];
        yield ['etat.acc_vehicule.catv', '32', 'Scooter > 50 cm3 et <= 125 cm3'];
        yield ['etat.acc_vehicule.catv', '33', 'Motocyclette > 125 cm3'];
        yield ['etat.acc_vehicule.catv', '34', 'Scooter > 125 cm3'];
        yield ['etat.acc_vehicule.catv', '35', 'Quad léger <= 50 cm3 (Quadricycle à moteur non carrossé)'];
        yield ['etat.acc_vehicule.catv', '36', 'Quad lourd > 50 cm3 (Quadricycle à moteur non carrossé)'];
        yield ['etat.acc_vehicule.catv', '37', 'Autobus'];
        yield ['etat.acc_vehicule.catv', '38', 'Autocar '];
        yield ['etat.acc_vehicule.catv', '39', 'Train'];
        yield ['etat.acc_vehicule.catv', '40', 'Tramway'];
        yield ['etat.acc_vehicule.catv', '41', '3RM <= 50 cm3'];
        yield ['etat.acc_vehicule.catv', '42', '3RM > 50 cm3 <= 125 cm3'];
        yield ['etat.acc_vehicule.catv', '43', '3RM > 125 cm3'];
        yield ['etat.acc_vehicule.catv', '50', 'EDP à moteur'];
        yield ['etat.acc_vehicule.catv', '60', 'EDP sans moteur'];
        yield ['etat.acc_vehicule.catv', '80', 'VAE'];
        yield ['etat.acc_vehicule.catv', '99', 'Autre véhicule'];

        yield ['etat.acc_vehicule.obs', '-1', 'Non renseigné'];
        yield ['etat.acc_vehicule.obs', '0', 'Sans objet'];
        yield ['etat.acc_vehicule.obs', '1', 'Véhicule en stationnement'];
        yield ['etat.acc_vehicule.obs', '2', 'Arbre'];
        yield ['etat.acc_vehicule.obs', '3', 'Glissière métallique'];
        yield ['etat.acc_vehicule.obs', '4', 'Glissière béton'];
        yield ['etat.acc_vehicule.obs', '5', 'Autre glissière'];
        yield ['etat.acc_vehicule.obs', '6', 'Bâtiment, mur, pile de pont'];
        yield ['etat.acc_vehicule.obs', '7', 'Support de signalisation verticale ou poste d\'appel d\'urgence'];
        yield ['etat.acc_vehicule.obs', '8', 'Poteau'];
        yield ['etat.acc_vehicule.obs', '9', 'Mobilier urbain '];
        yield ['etat.acc_vehicule.obs', '10', 'Parapet'];
        yield ['etat.acc_vehicule.obs', '11', 'Ilot, refuge, borne haute'];
        yield ['etat.acc_vehicule.obs', '12', 'Bordure de trottoir'];
        yield ['etat.acc_vehicule.obs', '13', 'Fossé, talus, paroi rocheuse'];
        yield ['etat.acc_vehicule.obs', '14', 'Autre obstacle fixe sur chaussée'];
        yield ['etat.acc_vehicule.obs', '15', 'Autre obstacle fixe sur trottoir ou accotement'];
        yield ['etat.acc_vehicule.obs', '16', 'Sortie de chaussée sans obstacle'];
        yield ['etat.acc_vehicule.obs', '17', 'Buse - tête d\'aqueduc'];

        yield ['etat.acc_vehicule.obsm', '-1', 'Non renseigné '];
        yield ['etat.acc_vehicule.obsm', '0', 'Aucun'];
        yield ['etat.acc_vehicule.obsm', '1', 'Piéton'];
        yield ['etat.acc_vehicule.obsm', '2', 'Véhicule'];
        yield ['etat.acc_vehicule.obsm', '4', 'Véhicule sur rail'];
        yield ['etat.acc_vehicule.obsm', '5', 'Animal domestique'];
        yield ['etat.acc_vehicule.obsm', '6', 'Animal sauvage'];
        yield ['etat.acc_vehicule.obsm', '9', 'Autre'];

        yield ['etat.acc_vehicule.choc', '-1', 'Non renseigné'];
        yield ['etat.acc_vehicule.choc', '0', 'Aucun'];
        yield ['etat.acc_vehicule.choc', '1', 'Avant'];
        yield ['etat.acc_vehicule.choc', '2', 'Avant droit'];
        yield ['etat.acc_vehicule.choc', '3', 'Avant gauche'];
        yield ['etat.acc_vehicule.choc', '4', 'Arrière'];
        yield ['etat.acc_vehicule.choc', '5', 'Arrière droit'];
        yield ['etat.acc_vehicule.choc', '6', 'Arrière gauche'];
        yield ['etat.acc_vehicule.choc', '7', 'Côté droit'];
        yield ['etat.acc_vehicule.choc', '8', 'Côté gauche'];
        yield ['etat.acc_vehicule.choc', '9', 'Chocs multiples (tonneaux)'];

        yield ['etat.acc_vehicule.manv', '-1', 'Non renseigné'];
        yield ['etat.acc_vehicule.manv', '0', 'Inconnue'];
        yield ['etat.acc_vehicule.manv', '1', 'Sans changement de direction'];
        yield ['etat.acc_vehicule.manv', '2', 'Même sens, même file'];
        yield ['etat.acc_vehicule.manv', '3', 'Entre 2 files'];
        yield ['etat.acc_vehicule.manv', '4', 'En marche arrière'];
        yield ['etat.acc_vehicule.manv', '5', 'A contresens'];
        yield ['etat.acc_vehicule.manv', '6', 'En franchissant le terre-plein central'];
        yield ['etat.acc_vehicule.manv', '7', 'Dans le couloir bus, dans le même sens'];
        yield ['etat.acc_vehicule.manv', '8', 'Dans le couloir bus, dans le sens inverse '];
        yield ['etat.acc_vehicule.manv', '9', 'En s\'insérant'];
        yield ['etat.acc_vehicule.manv', '10', 'En faisant demi-tour sur la chaussée'];
        yield ['etat.acc_vehicule.manv', '11', 'Changement de file - à gauche'];
        yield ['etat.acc_vehicule.manv', '12', 'Changement de file - à droite'];
        yield ['etat.acc_vehicule.manv', '13', 'Déporté - à gauche'];
        yield ['etat.acc_vehicule.manv', '14', 'Déporté - à droite'];
        yield ['etat.acc_vehicule.manv', '15', 'Tournant - à gauche'];
        yield ['etat.acc_vehicule.manv', '16', 'Tournant - à droite'];
        yield ['etat.acc_vehicule.manv', '17', 'Dépassant - à gauche'];
        yield ['etat.acc_vehicule.manv', '18', 'Dépassant - à droite'];
        yield ['etat.acc_vehicule.manv', '19', 'Traversant la chaussée'];
        yield ['etat.acc_vehicule.manv', '20', 'Manœuvre de stationnement'];
        yield ['etat.acc_vehicule.manv', '21', 'Manœuvre d\'évitement'];
        yield ['etat.acc_vehicule.manv', '22', 'Ouverture de porte'];
        yield ['etat.acc_vehicule.manv', '23', 'Arrêté (hors stationnement)'];
        yield ['etat.acc_vehicule.manv', '24', 'En stationnement (avec occupants)'];
        yield ['etat.acc_vehicule.manv', '25', 'Circulant sur trottoir'];
        yield ['etat.acc_vehicule.manv', '26', 'Autres manœuvres'];

        yield ['etat.acc_vehicule.motor', '-1', 'Non renseigné'];
        yield ['etat.acc_vehicule.motor', '0', 'Inconnue'];
        yield ['etat.acc_vehicule.motor', '1', 'Hydrocarbures'];
        yield ['etat.acc_vehicule.motor', '2', 'Hybride électrique'];
        yield ['etat.acc_vehicule.motor', '3', 'Électrique'];
        yield ['etat.acc_vehicule.motor', '4', 'Hydrogène'];
        yield ['etat.acc_vehicule.motor', '5', 'Humaine'];
        yield ['etat.acc_vehicule.motor', '6', 'Autre'];

        // USAGER
        yield ['etat.acc_usager.catu', '1', 'Conducteur'];
        yield ['etat.acc_usager.catu', '2', 'Passager'];
        yield ['etat.acc_usager.catu', '3', 'Piéton'];

        yield ['etat.acc_usager.grav', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.grav', '1', 'Indemne'];
        yield ['etat.acc_usager.grav', '2', 'Tué'];
        yield ['etat.acc_usager.grav', '3', 'Blessé hospitalisé'];
        yield ['etat.acc_usager.grav', '4', 'Blessé léger'];

        yield ['etat.acc_usager.sexe', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.sexe', '1', 'Masculin'];
        yield ['etat.acc_usager.sexe', '2', 'Féminin'];

        yield ['etat.acc_usager.trajet', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.trajet', '0', 'Non renseigné'];
        yield ['etat.acc_usager.trajet', '1', 'Domicile - travail'];
        yield ['etat.acc_usager.trajet', '2', 'Domicile - école'];
        yield ['etat.acc_usager.trajet', '3', 'Courses - achats'];
        yield ['etat.acc_usager.trajet', '4', 'Utilisation professionnelle'];
        yield ['etat.acc_usager.trajet', '5', 'Promenade - loisirs'];
        yield ['etat.acc_usager.trajet', '9', 'Autre'];

        yield ['etat.acc_usager.secu1', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.secu1', '0', 'Aucun équipement'];
        yield ['etat.acc_usager.secu1', '1', 'Ceinture'];
        yield ['etat.acc_usager.secu1', '2', 'Casque'];
        yield ['etat.acc_usager.secu1', '3', 'Dispositif enfants'];
        yield ['etat.acc_usager.secu1', '4', 'Gilet réfléchissant'];
        yield ['etat.acc_usager.secu1', '5', 'Airbag (2RM/3RM)'];
        yield ['etat.acc_usager.secu1', '6', 'Gants (2RM/3RM)'];
        yield ['etat.acc_usager.secu1', '7', 'Gants + Airbag (2RM/3RM)'];
        yield ['etat.acc_usager.secu1', '8', 'Non déterminable'];
        yield ['etat.acc_usager.secu1', '9', 'Autre'];

        yield ['etat.acc_usager.secu2', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.secu2', '0', 'Aucun équipement'];
        yield ['etat.acc_usager.secu2', '1', 'Ceinture'];
        yield ['etat.acc_usager.secu2', '2', 'Casque'];
        yield ['etat.acc_usager.secu2', '3', 'Dispositif enfants'];
        yield ['etat.acc_usager.secu2', '4', 'Gilet réfléchissant'];
        yield ['etat.acc_usager.secu2', '5', 'Airbag (2RM/3RM)'];
        yield ['etat.acc_usager.secu2', '6', 'Gants (2RM/3RM)'];
        yield ['etat.acc_usager.secu2', '7', 'Gants + Airbag (2RM/3RM)'];
        yield ['etat.acc_usager.secu2', '8', 'Non déterminable'];
        yield ['etat.acc_usager.secu2', '9', 'Autre'];

        yield ['etat.acc_usager.secu3', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.secu3', '0', 'Aucun équipement'];
        yield ['etat.acc_usager.secu3', '1', 'Ceinture'];
        yield ['etat.acc_usager.secu3', '2', 'Casque'];
        yield ['etat.acc_usager.secu3', '3', 'Dispositif enfants'];
        yield ['etat.acc_usager.secu3', '4', 'Gilet réfléchissant'];
        yield ['etat.acc_usager.secu3', '5', 'Airbag (2RM/3RM)'];
        yield ['etat.acc_usager.secu3', '6', 'Gants (2RM/3RM)'];
        yield ['etat.acc_usager.secu3', '7', 'Gants + Airbag (2RM/3RM)'];
        yield ['etat.acc_usager.secu3', '8', 'Non déterminable'];
        yield ['etat.acc_usager.secu3', '9', 'Autre'];

        yield ['etat.acc_usager.locp', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.locp', '0', 'Sans objet'];
        yield ['etat.acc_usager.locp', '1', 'Sur chaussée - A +50m du passage piéton'];
        yield ['etat.acc_usager.locp', '2', 'Sur chaussée - A -50m du passage piéton'];
        yield ['etat.acc_usager.locp', '3', 'Sur passage piéton - Sans signalisation lumineuse'];
        yield ['etat.acc_usager.locp', '4', 'Sur passage piéton - Avec signalisation lumineuse'];
        yield ['etat.acc_usager.locp', '5', 'Sur trottoir'];
        yield ['etat.acc_usager.locp', '6', 'Sur accotement'];
        yield ['etat.acc_usager.locp', '7', 'Sur refuge ou BAU'];
        yield ['etat.acc_usager.locp', '8', 'Sur contre allée'];
        yield ['etat.acc_usager.locp', '9', 'Inconnue'];

        yield ['etat.acc_usager.actp', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.actp', '0', 'Se déplaçant - Non renseigné ou sans objet'];
        yield ['etat.acc_usager.actp', '1', 'Se déplaçant - Sens véhicule heurtant'];
        yield ['etat.acc_usager.actp', '2', 'Se déplaçant - Sens inverse du véhicule'];
        yield ['etat.acc_usager.actp', '3', 'Traversant'];
        yield ['etat.acc_usager.actp', '4', 'Masqué'];
        yield ['etat.acc_usager.actp', '5', 'Jouant - courant'];
        yield ['etat.acc_usager.actp', '6', 'Avec animal'];
        yield ['etat.acc_usager.actp', '9', 'Autre'];
        yield ['etat.acc_usager.actp', 'A', 'Monte/descend du véhicule'];
        yield ['etat.acc_usager.actp', 'B', 'Inconnue'];

        yield ['etat.acc_usager.etatp', '-1', 'Non renseigné'];
        yield ['etat.acc_usager.etatp', '1', 'Seul'];
        yield ['etat.acc_usager.etatp', '2', 'Accompagné'];
        yield ['etat.acc_usager.etatp', '3', 'En groupe'];
    }
}
