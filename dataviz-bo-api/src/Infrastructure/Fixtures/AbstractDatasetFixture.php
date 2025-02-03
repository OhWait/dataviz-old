<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\Dataset;
use App\Domain\Model\Theme;
use App\Domain\ValueObject\Dataset\DatasetDataCreatedAt;
use App\Domain\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\ValueObject\Dataset\DatasetDataUpdatedAt;
use App\Domain\ValueObject\Dataset\DatasetDescription;
use App\Domain\ValueObject\Dataset\DatasetGranularity;
use App\Domain\ValueObject\Dataset\DatasetLanguage;
use App\Domain\ValueObject\Dataset\DatasetPerimeter;
use App\Domain\ValueObject\Dataset\DatasetSecurity;
use App\Domain\ValueObject\Dataset\DatasetShortTitle;
use App\Domain\ValueObject\Dataset\DatasetSlug;
use App\Domain\ValueObject\Dataset\DatasetTitle;
use App\Domain\ValueObject\Dataset\DatasetUpdateFrequency;
use App\Domain\ValueObject\Dataset\DatasetUpdatePeriod;
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
