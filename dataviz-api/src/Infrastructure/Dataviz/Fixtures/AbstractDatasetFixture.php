<?php

declare(strict_types=1);

namespace App\Infrastructure\Dataviz\Fixtures;

use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\Model\Theme;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataCreatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataUpdatedAt;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDescription;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetGranularity;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetLanguage;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetPerimeter;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSecurity;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetShortTitle;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetTitle;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdateFrequency;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetUpdatePeriod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDatasetFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            ProviderFixture::class,
            ThemeFixture::class,
        ];
    }

    public function load(ObjectManager $em): void
    {
        foreach ($this->getDatasets() as $data) {
            list(
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
            ) = $data;

            $dataset = new Dataset(
                slug: new DatasetSlug($slug),
                title: new DatasetTitle($title),
                shortTitle: new DatasetShortTitle($shortTitle),
                description: new DatasetDescription($description),
                perimeter: new DatasetPerimeter($perimeter),
                granularity: new DatasetGranularity($granularity),
                updateFrequency: new DatasetUpdateFrequency($updateFrequency),
                updatePeriod: new DatasetUpdatePeriod($updatePeriod),
                security: new DatasetSecurity($security),
                language: new DatasetLanguage($language),
                dataCreatedAt: new DatasetDataCreatedAt($dataCreatedAt),
                dataUpdatedAt: new DatasetDataUpdatedAt($dataUpdatedAt),
                provider: $this->getReference($provider),
                dataProvider: new DatasetDataProvider($dataProvider),
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
