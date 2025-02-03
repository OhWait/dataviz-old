<?php

declare(strict_types=1);

namespace App\Presentation\State\Processor\Dataset;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\ParameterValidator\Exception\ValidationException;
use App\Application\Command\Dataset\UpdateDatasetCommand;
use App\Domain\Model\Dataset;
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
use App\Domain\ValueObject\Provider\ProviderSlug;
use App\Presentation\Resource\DatasetResource;
use App\Presentation\Resource\ThemeResource;
use App\Shared\Presentation\AbstractProcessor;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @extends AbstractProcessor<DatasetResource, DatasetResource>
 */
final class DatasetUpdateProcessor extends AbstractProcessor
{
    public function __construct(
        protected MessageBusInterface $bus,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): DatasetResource {
        try {
            $dataset = $this->updateCommand($data);

            return DatasetResource::fromDomain($dataset);
        } catch (\Exception $e) {
            throw new ValidationException([], $e->getPrevious()->getMessage());
        }
    }

    private function updateCommand(DatasetResource $data): Dataset
    {
        $command = new UpdateDatasetCommand(
            slug: new DatasetSlug($data->slug),
            title: new DatasetTitle($data->title),
            shortTitle: new DatasetShortTitle($data->shortTitle),
            description: new DatasetDescription($data->description),
            perimeter: new DatasetPerimeter($data->perimeter),
            granularity: new DatasetGranularity($data->granularity),
            updateFrequency: new DatasetUpdateFrequency($data->updateFrequency),
            updatePeriod: new DatasetUpdatePeriod($data->updatePeriod),
            security: new DatasetSecurity($data->security),
            language: new DatasetLanguage($data->language),
            dataCreatedAt: new DatasetDataCreatedAt($data->dataCreatedAt),
            dataUpdatedAt: new DatasetDataUpdatedAt($data->dataUpdatedAt),
            dataProvider: new DatasetDataProvider($data->dataProvider),
            provider: new ProviderSlug($data->provider->slug),
            themes: null !== $data->themes ? \array_map(
                fn (ThemeResource $theme) => $theme->slug,
                $data->themes,
            ) : null,
        );

        return $this->dispatch($command);
    }
}
