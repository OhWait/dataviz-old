<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\Theme;
use App\Domain\ValueObject\Theme\ThemeSlug;
use App\Domain\ValueObject\Theme\ThemeTitle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixture extends Fixture
{
    public function load(ObjectManager $em): void
    {
        foreach ($this->getThemes() as $data) {
            list($title, $slug) = $data;

            $theme = new Theme(
                slug: new ThemeSlug($slug),
                title: new ThemeTitle($title),
            );

            $em->persist($theme);
            $this->addReference($slug, $theme);
        }

        $em->flush();
    }

    private function getThemes(): \Generator
    {
        yield ['Économie', 'economie'];
        yield ['Éducation', 'education'];
        yield ['Emploi', 'emploi'];
        yield ['Foncier', 'foncier'];
        yield ['Habitat', 'habitat'];
        yield ['Mobilité', 'mobilite'];
        yield ['Population', 'population'];
    }
}
