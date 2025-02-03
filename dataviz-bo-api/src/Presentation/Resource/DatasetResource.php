<?php

declare(strict_types=1);

namespace App\Presentation\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Enum\Dataset\DataProviderEnum;
use App\Domain\Enum\Dataset\FrequencyEnum;
use App\Domain\Enum\Dataset\GranularityEnum;
use App\Domain\Enum\Dataset\LanguageEnum;
use App\Domain\Enum\Dataset\OrderByEnum;
use App\Domain\Enum\Dataset\SecurityEnum;
use App\Domain\Model\Dataset;
use App\Presentation\Enum\DatasetGroupEnum;
use App\Presentation\State\Processor\Dataset\DatasetCreateProcessor;
use App\Presentation\State\Processor\Dataset\DatasetDeleteProcessor;
use App\Presentation\State\Processor\Dataset\DatasetUpdateProcessor;
use App\Presentation\State\Provider\DatasetCollectionProvider;
use App\Presentation\State\Provider\DatasetItemProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[API\ApiResource(
    shortName: 'Dataset',
    operations: [
        // basic crud
        new API\GetCollection(
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION],
            ],
            provider: DatasetCollectionProvider::class,
            openapiContext: [
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'dataProvider',
                        'schema' => ['type' => 'boolean'],
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'themes',
                        'schema' => [
                            'type' => 'array',
                            'items' => ['type' => 'string'],
                        ],
                        'explode' => true,
                        'required' => false,
                    ],
                    [
                        'in' => 'query',
                        'name' => 'orderBy',
                        'schema' => [
                            'type' => 'string',
                            'enum' => self::ORDER_BY,
                        ],
                        'required' => false,
                    ],
                ],
            ],
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::GET],
            ],
            provider: DatasetItemProvider::class,
        ),

        new API\Post(
            validationContext: [
                'groups' => [DatasetGroupEnum::POST, DatasetGroupEnum::PATCH],
            ],
            denormalizationContext: [
                'groups' => [DatasetGroupEnum::POST, DatasetGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::GET],
            ],
            processor: DatasetCreateProcessor::class,
        ),

        new API\Patch(
            validationContext: ['groups' => [DatasetGroupEnum::PATCH]],
            denormalizationContext: [
                'groups' => [DatasetGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [DatasetGroupEnum::GET_COLLECTION, DatasetGroupEnum::GET],
            ],
            processor: DatasetUpdateProcessor::class,
            provider: DatasetItemProvider::class,
        ),

        new API\Delete(
            provider: DatasetItemProvider::class,
            processor: DatasetDeleteProcessor::class,
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
        GranularityEnum::MUNICIPALITIE->value,
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
            Assert\NotBlank(groups: [DatasetGroupEnum::POST]),
            Assert\Length(max: 255, groups: [DatasetGroupEnum::POST]),
            Assert\Type('string', groups: [DatasetGroupEnum::POST]),
            API\ApiProperty(
                identifier: true,
                readable: true,
                writable: true,
                openapiContext: ['type' => 'string', 'maxLength' => 255],
                required: true,
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::POST,
            ]),
        ]
        public ?string $slug = null,

        #[
            Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
            Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
            Assert\Type('string', groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: ['type' => 'string', 'maxLength' => 255],
                required: true,
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ])
        ]
        public ?string $title = null,

        #[
            Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(openapiContext: ['type' => 'string', 'maxLength' => 255]),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::POST,
                DatasetGroupEnum::PATCH,
            ])
        ]
        public ?string $shortTitle = null,

        #[
            Assert\NotBlank(allowNull: true, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(openapiContext: ['type' => 'string', 'nullable' => true]),
            Groups([
                DatasetGroupEnum::GET,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?string $description = null,

        #[
            Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
            Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
            Assert\Type('string', groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: ['type' => 'string', 'maxLength' => 255],
                required: true,
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ])
        ]
        public ?string $perimeter = null,

        #[
            Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
            Assert\Choice(choices: self::GRANULARITY, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'enum' => self::GRANULARITY,
                ],
                required: true,
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?string $granularity = null,

        #[
            Assert\Choice(choices: self::FREQUENCY, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'nullable' => true,
                    'enum' => self::FREQUENCY,
                ],
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?string $updateFrequency = null,

        #[
            Assert\NotBlank(allowNull: true, groups: [DatasetGroupEnum::PATCH]),
            Assert\Length(max: 255, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'maxLength' => 255,
                    'nullable' => true,
                ],
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?string $updatePeriod = null,

        #[
            Assert\NotBlank(groups: [DatasetGroupEnum::PATCH]),
            Assert\Choice(choices: self::SECURITY, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: ['type' => 'string', 'enum' => self::SECURITY],
                required: true,
            ),
            Groups([DatasetGroupEnum::PATCH]),
        ]
        public ?string $security = null,

        #[
            Assert\Choice(choices: self::LANGUAGE, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'nullable' => true,
                    'enum' => self::LANGUAGE,
                ],
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?string $language = null,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                    'nullable' => true,
                ],
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?\DateTimeInterface $dataCreatedAt = null,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                    'nullable' => true,
                ],
            ),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?\DateTimeInterface $dataUpdatedAt = null,

        #[
            Assert\Choice(choices: self::DATA_PROVIDER, groups: [DatasetGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'nullable' => true,
                ],
            ),
            Groups([DatasetGroupEnum::PATCH]),
        ]
        public ?string $dataProvider = null,

        #[
            Assert\NotBlank(groups: [DatasetGroupEnum::POST]),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?ProviderResource $provider = null,

        #[
            Assert\NotBlank(groups: [DatasetGroupEnum::POST]),
            Assert\Count(min: 1, groups: [DatasetGroupEnum::POST]),
            Assert\Type('array', groups: [DatasetGroupEnum::PATCH]),
            Groups([
                DatasetGroupEnum::GET_COLLECTION,
                DatasetGroupEnum::PATCH,
            ]),
        ]
        public ?array $themes = [],

        #[Groups([DatasetGroupEnum::GET])]
        public ?array $dataEntries = [],

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                ],
            ),
            Groups([DatasetGroupEnum::GET])
        ]
        public ?\DateTimeInterface $createdAt = null,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'format' => 'date',
                ],
            ),
            Groups([DatasetGroupEnum::GET])
        ]
        public ?\DateTimeInterface $updatedAt = null,
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
