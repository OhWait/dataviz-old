<?php

declare(strict_types=1);

namespace App\Fixtures\ByProvider\Etat\Accidentologie;

use App\Enum\Dataset\DataProviderEnum;
use App\Enum\Dataset\FrequencyEnum;
use App\Enum\Dataset\GranularityEnum;
use App\Enum\Dataset\LanguageEnum;
use App\Enum\Dataset\SecurityEnum;
use App\Fixtures\AbstractDatasetFixture;

class DatasetEtatAccFixture extends AbstractDatasetFixture
{
    protected function getDatasets(): \Generator
    {
        yield $this->overload(
            'accidents',
            'Bases de données annuelles des accidents corporels de la circulation routière',
            'Accidents de la circulation',
        );
    }

    private function overload(
        string $slug,
        string $title,
        string $shortTitle,
    ): array {
        return [
            $slug,
            $title,
            $shortTitle,
            "<p>Pour chaque accident corporel (soit un accident survenu sur une voie ouverte à la circulation publique, impliquant au moins un véhicule et 
            ayant fait au moins une victime ayant nécessité des soins), des saisies d'information décrivant l'accident sont effectuées par l'unité des 
            forces de l'ordre (police, gendarmerie, etc.) qui est intervenue sur le lieu de l'accident. Ces saisies sont rassemblées dans une fiche 
            intitulée bulletin d'analyse des accidents corporels. 
            L'ensemble de ces fiches constitue le fichier national des accidents corporels de la circulation dit « Fichier BAAC » administré par l'Observatoire 
            national interministériel de la sécurité routière \"ONISR\".</p>
            
            <p>Les bases de données, extraites du fichier BAAC, répertorient l'intégralité des accidents corporels de la circulation, 
            intervenus durant une année précise en France métropolitaine, dans les départements d'Outre-mer (Guadeloupe, Guyane, Martinique, 
            La Réunion et Mayotte depuis 2012) et dans les autres territoires d'outre-mer (Saint-Pierre-et-Miquelon, Saint-Barthélemy, Saint-Martin, Wallis-et-Futuna, 
            Polynésie française et Nouvelle-Calédonie ; disponible qu'à partir de 2019 dans l'open data) 
            avec une description simplifiée. Cela comprend des informations de localisation de l'accident, 
            telles que renseignées ainsi que des informations concernant les caractéristiques de l'accident et son lieu, les véhicules impliqués et leurs victimes.</p>

            <p>Par rapport aux bases de données agrégées 2005-2010 et 2006-2011 actuellement disponibles sur le site www.data.gouv.fr, les bases de données de 2005 
            à 2022 sont désormais annuelles et composées de 4 fichiers (Caractéristiques – Lieux – Véhicules – Usagers) au format csv.</p>

            <p>Ces bases occultent néanmoins certaines données spécifiques relatives aux usagers et aux véhicules et à leur comportement dans la mesure où la 
            divulgation de ces données porterait atteinte à la protection de la vie privée des personnes physiques aisément identifiables ou ferait apparaître 
            le comportement de telles personnes alors que la divulgation de ce comportement pourrait leur porter préjudice (avis de la CADA – 2 janvier 2012).</p>

            <p>Avertissement : Les données sur la qualification de blessé hospitalisé depuis l'année 2018 ne peuvent être comparées aux années précédentes 
            suite à des modifications de process de saisie des forces de l'ordre. L'indicateur « blessé hospitalisé » n'est plus labellisé par l'autorité 
            de la statistique publique depuis 2019.</p>

            <p>La validité des exploitations statistiques qui peuvent être faites à partir de cette base dépend des modes de vérifications propres dans le domaine 
            d'application de la sécurité routière et notamment d'une connaissance précise des définitions afférentes à chaque variable utilisée. 
            Pour toute exploitation, il est important de prendre notamment connaissance de la structure de la fiche BAAC jointe ainsi que du guide 
            d'utilisation de la codification du bulletin d'analyse des accidents corporels de la circulation.</p>

            <p>Rappelons qu'un certain nombre d'indicateurs issus de cette base font l'objet d'une labellisation, par l'autorité de la statistique publique 
            (arrêté du 27 novembre 2019).<p>",
            'France',
            GranularityEnum::POI->value,
            FrequencyEnum::YEARLY->value,
            'Décembre',
            SecurityEnum::PUBLIC->value,
            LanguageEnum::FR->value,
            new \DateTime('2013-07-08'),
            new \DateTime('2022-11-30'),
            'miom',
            DataProviderEnum::ACCIDENTOLOGY->value,
            ['mobilite'],
        ];
    }
}
