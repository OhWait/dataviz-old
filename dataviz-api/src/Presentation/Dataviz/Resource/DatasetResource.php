<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Domain\Dataviz\Enum\Dataset\FrequencyEnum;
use App\Domain\Dataviz\Enum\Dataset\GranularityEnum;
use App\Domain\Dataviz\Enum\Dataset\LanguageEnum;
use App\Domain\Dataviz\Enum\Dataset\OrderByEnum;
use App\Domain\Dataviz\Enum\Dataset\SecurityEnum;
use App\Domain\Dataviz\Model\Dataset;
use App\Presentation\Dataviz\Enum\DatasetGroupEnum;
use App\Presentation\Dataviz\State\Provider\DatasetCollectionProvider;
use App\Presentation\Dataviz\State\Provider\DatasetItemProvider;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[API\ApiResource(
    shortName: 'Dataset',
    operations: [
        new API\GetCollection(
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION],
            ],
            provider: DatasetCollectionProvider::class,
            parameters: [
                new API\QueryParameter(
                    key: 'dataProvider',
                    schema: ['type' => 'boolean']
                ),
                new API\QueryParameter(
                    key: 'themes',
                    schema: [
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                    ],
                ),
                new API\QueryParameter(
                    key: 'orderBy',
                    schema: [
                        'type' => 'string',
                        'enum' => self::ORDER_BY,
                    ],
                ),
            ],
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::GET],
            ],
            provider: DatasetItemProvider::class,
        ),
    ],
)]
class DatasetResource
{
    /**
     * @var string[] ORDER_BY
     */
    public const ORDER_BY = [
        OrderByEnum::DATA_UPDATED_AT->value,
        OrderByEnum::CATEGORY->value,
    ];

    /**
     * @var string[] GRANULARITY
     */
    public const GRANULARITY = [
        GranularityEnum::POI->value,
        GranularityEnum::MUNICIPALITY->value,
        GranularityEnum::PIIC->value,
        GranularityEnum::DEPARTMENT->value,
        GranularityEnum::COUNTRY->value,
        GranularityEnum::OTHER->value,
    ];

    /**
     * @var string[] FREQUENCY
     */
    public const FREQUENCY = [
        FrequencyEnum::DAILY->value,
        FrequencyEnum::WEEKLY->value,
        FrequencyEnum::MONTHLY->value,
        FrequencyEnum::QUARTERLY->value,
        FrequencyEnum::HALF_YEARLY->value,
        FrequencyEnum::YEARLY->value,
    ];

    /**
     * @var string[] LANGUAGE
     */
    public const LANGUAGE = [
        LanguageEnum::FR->value,
        LanguageEnum::EN->value,
    ];

    /**
     * @var string[] SECURITY
     */
    public const SECURITY = [
        SecurityEnum::PUBLIC->value,
        SecurityEnum::PRENIUM->value,
    ];

    /**
     * @var string[] DATA_PROVIDER
     */
    public const DATA_PROVIDER = [
        DataProviderEnum::ACCIDENTOLOGY->value,
        DataProviderEnum::INSEE_TD->value,
    ];

    /**
     * @param DataEntryResource[] $dataEntries
     * @param ThemeResource[]     $themes
     */
    public function __construct(
        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $slug,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $title,

        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?string $shortTitle,

        #[Groups([DatasetGroupEnum::GET])]
        public ?string $description,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $perimeter,

        #[API\ApiProperty(openapiContext: ['enum' => self::GRANULARITY], required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $granularity,

        #[API\ApiProperty(openapiContext: ['enum' => self::FREQUENCY])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?string $updateFrequency,

        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?string $updatePeriod,

        #[API\ApiProperty(openapiContext: ['enum' => self::LANGUAGE])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?string $language,

        #[API\ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date'])]
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?\DateTimeInterface $dataCreatedAt,

        #[API\ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date'])]
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?\DateTimeInterface $dataUpdatedAt,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ProviderResource $provider,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public array $themes,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET])]
        public array $dataEntries,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET])]
        public \DateTimeInterface $createdAt,

        #[API\ApiProperty(required: true)]
        #[Groups([DatasetGroupEnum::GET])]
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function fromDomain(Dataset $dataset): self
    {
        return new self(
            slug: $dataset->slug()->value,
            title: $dataset->title()->value,
            shortTitle: $dataset->shortTitle()->value,
            description: $dataset->description()->value,
            perimeter: $dataset->perimeter()->value,
            granularity: $dataset->granularity()->value(),
            updateFrequency: $dataset->updateFrequency()->value(),
            updatePeriod: $dataset->updatePeriod()->value,
            language: $dataset->language()->value(),
            dataCreatedAt: $dataset->dataCreatedAt()->value,
            dataUpdatedAt: $dataset->dataUpdatedAt()->value,
            provider: ProviderResource::fromDomain($dataset->provider()),
            dataEntries: DataEntryResource::fromArrayDomain($dataset->dataEntries()->toArray()),
            themes: ThemeResource::fromArrayDomain($dataset->themes()->toArray()),
            createdAt: $dataset->createdAt()->value,
            updatedAt: $dataset->updatedAt()->value,
        );
    }

    /**
     * @param Dataset[] $datasets
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $datasets): array
    {
        return \array_map(
            fn (Dataset $dataset) => self::fromDomain($dataset),
            $datasets,
        );
    }

    public function addDataEntry(DataEntryResource $dataEntry): self
    {
        $this->dataEntries[] = $dataEntry;

        return $this;
    }

    public function addTheme(ThemeResource $theme): self
    {
        $this->themes[] = $theme;

        return $this;
    }
}
