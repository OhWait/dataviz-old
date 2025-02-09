<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Entity\Dataset;
use App\Entity\Provider;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDatasetFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            ProviderFixture::class,
            ThemeFixture::class,
        ];
    }

    public function load(ObjectManager $em): void
    {
        foreach ($this->getDatasets() as $data) {
            [
                $slug,
                $title,
                $shortTitle,
                $description,
                $perimeter,
                $granularity,
                $updateFrequency,
                $updatePeriod,
                $security,
                $language,
                $dataCreatedAt,
                $dataUpdatedAt,
                $provider,
                $dataProvider,
                $themes,
            ] = $data;

            $dataset = new Dataset(
                slug: $slug,
                title: $title,
                shortTitle: $shortTitle,
                description: $description,
                perimeter: $perimeter,
                granularity: $granularity,
                updateFrequency: $updateFrequency,
                updatePeriod: $updatePeriod,
                security: $security,
                language: $language,
                dataCreatedAt: $dataCreatedAt,
                dataUpdatedAt: $dataUpdatedAt,
                provider: $this->getReference($provider, Provider::class),
                dataProvider: $dataProvider,
                themes: \array_map(
                    fn (string $theme) => $this->getReference($theme, Theme::class),
                    $themes,
                ),
            );

            $this->addReference($slug, $dataset);
            $em->persist($dataset);
        }

        $em->flush();
    }

    abstract protected function getDatasets(): \Generator;
}
