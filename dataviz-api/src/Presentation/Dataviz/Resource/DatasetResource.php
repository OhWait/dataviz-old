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
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'Dataset',
    operations: [
        new API\GetCollection(
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION],
            ],
            provider: DatasetCollectionProvider::class,
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
        #[
            API\ApiProperty(
                identifier: true,
                readable: true,
                writable: true,
                required: true,
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public string $slug,

        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $title,

        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?string $shortTitle,

        #[Groups([DatasetGroupEnum::GET])]
        public ?string $description,

        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public string $perimeter,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'enum' => self::GRANULARITY,
                ],
                required: true,
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public string $granularity,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'nullable' => true,
                    'enum' => self::FREQUENCY,
                ],
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public ?string $updateFrequency,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'maxLength' => 255,
                    'nullable' => true,
                ],
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public ?string $updatePeriod,

        #[
            API\ApiProperty(
                openapiContext: ['type' => 'string', 'enum' => self::SECURITY],
                required: true,
            ),
        ]
        public string $security,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'nullable' => true,
                    'enum' => self::LANGUAGE,
                ],
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public ?string $language,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                    'nullable' => true,
                ],
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public ?\DateTimeInterface $dataCreatedAt,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                    'nullable' => true,
                ],
            ),
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public ?\DateTimeInterface $dataUpdatedAt,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'nullable' => true,
                ],
            ),
        ]
        public ?string $dataProvider,

        #[
            Groups([DatasetGroupEnum::GET_COLLECTION]),
        ]
        public ?ProviderResource $provider,

        #[Groups([DatasetGroupEnum::GET_COLLECTION])]
        public ?array $themes,

        #[Groups([DatasetGroupEnum::GET])]
        public ?array $dataEntries,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                ],
            ),
            Groups([DatasetGroupEnum::GET])
        ]
        public ?\DateTimeInterface $createdAt,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                ],
            ),
            Groups([DatasetGroupEnum::GET])
        ]
        public ?\DateTimeInterface $updatedAt,
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
            security: $dataset->security()->value(),
            language: $dataset->language()->value(),
            dataCreatedAt: $dataset->dataCreatedAt()->value,
            dataUpdatedAt: $dataset->dataUpdatedAt()->value,
            dataProvider: $dataset->dataProvider()->value(),
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
