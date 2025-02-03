<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\Provider;
use App\Domain\ValueObject\Provider\ProviderAcronym;
use App\Domain\ValueObject\Provider\ProviderDescription;
use App\Domain\ValueObject\Provider\ProviderName;
use App\Domain\ValueObject\Provider\ProviderSlug;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProviderFixture extends Fixture
{
    public function load(ObjectManager $em): void
    {
        foreach ($this->getProviders() as $data) {
            list($name, $slug, $acronym, $description) = $data;

            $provider = new Provider(
                slug: new ProviderSlug($slug),
                name: new ProviderName($name),
                acronym: new ProviderAcronym($acronym),
                description: new ProviderDescription($description),
            );

            $em->persist($provider);
            $this->addReference($slug, $provider);
        }

        $em->flush();
    }

    private function getProviders(): \Generator
    {
        yield [
            'Institut national de la statistique et des études économiques',
            'insee',
            'INSEE',
            'L\'Institut national de la statistique et des études économiques (Insee) collecte, produit, analyse et diffuse des informations sur l\'économie et la société françaises. Ces informations intéressent les pouvoirs publics, les administrations, les entreprises, les chercheurs, les médias, les enseignants, les étudiants, les particuliers. Elles leur permettent d\'enrichir leurs connaissances, d\'effectuer des études, de faire des prévisions et de prendre des décisions. Pour satisfaire ses utilisateurs, l\'Insee est à l\'écoute de leurs besoins et oriente ses travaux en conséquence en poursuivant un objectif principal : éclairer le débat économique et social.',
        ];
        yield [
            'Ministère de l\'Intérieur et des Outre-Mer',
            'miom',
            'MIOM',
            'Placé au cœur de l\'État, le ministère de l\'intérieur et des outre-mer assure la permanence et la continuité de l\'État. Cette fonction régalienne se concrétise par le rôle majeur et les services rendus par le réseau des préfectures et des sous-préfectures aux citoyens de métropole et d\'outre-mer. Au quotidien, le ministère de l\'intérieur et des outre-mer est le garant de la sécurité des Français : sécurités publique, civile, routière... Le ministère de l\'intérieur et des outre-mer est, à ce titre, un ministère opérationnel capable d\'agir et de réagir à tout moment pour protéger les populations, notamment, lors de crises majeures. Il est aussi le garant du libre exercice et du respect des libertés publiques : libertés de circulation, de vote, d\'association, de culte, d\'installation dans des conditions régulières pour ceux qui viennent de l\'étranger. Il veille, enfin, au respect des libertés locales et des compétences des collectivités territoriales.',
        ];
    }
}
