<?php

declare(strict_types=1);

namespace App\Application\Command\Dataset;

use App\Domain\Model\Dataset;
use App\Domain\Repository\DatasetRepositoryInterface;
use App\Domain\Repository\ProviderRepositoryInterface;
use App\Domain\Repository\ThemeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class CreateDatasetCommandHandler
{
    public function __construct(
        private readonly DatasetRepositoryInterface $datasetRepository,
        private readonly ProviderRepositoryInterface $providerRepository,
        private readonly ThemeRepositoryInterface $themeRepository,
    ) {
    }

    public function __invoke(CreateDatasetCommand $command): Dataset
    {
        $provider = $this->providerRepository->find($command->provider->value);
        $themes = $this->themeRepository->findBy(['slug.value' => $command->themes]);

        $dataset = new Dataset(
            slug: $command->slug,
            title: $command->title,
            shortTitle: $command->shortTitle,
            description: $command->description,
            perimeter: $command->perimeter,
            granularity: $command->granularity,
            updateFrequency: $command->updateFrequency,
            updatePeriod: $command->updatePeriod,
            security: $command->security,
            language: $command->language,
            dataCreatedAt: $command->dataCreatedAt,
            dataUpdatedAt: $command->dataUpdatedAt,
            provider: $provider,
            dataProvider: $command->dataProvider,
            themes: $themes,
        );

        $this->datasetRepository->save($dataset);

        return $this->datasetRepository->find($command->slug);
    }
}
