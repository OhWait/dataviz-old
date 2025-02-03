<?php

declare(strict_types=1);

namespace App\Presentation\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Model\DataEntry;
use App\Presentation\Enum\DataEntryGroupEnum;
use App\Presentation\Enum\DatasetGroupEnum;
use App\Presentation\State\Processor\DataEntry\DataEntryCreateProcessor;
use App\Presentation\State\Processor\DataEntry\DataEntryDeleteProcessor;
use App\Presentation\State\Processor\DataEntry\DataEntryUpdateProcessor;
use App\Presentation\State\Provider\DataEntryCollectionProvider;
use App\Presentation\State\Provider\DataEntryItemProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[API\ApiResource(
    shortName: 'DataEntry',
    // security: "is_granted('ROLE_ADMIN')",
    operations: [
        // basic crud
        new API\GetCollection(
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::GET_COLLECTION],
            ],
            provider: DataEntryCollectionProvider::class,
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::GET],
            ],
            provider: DataEntryItemProvider::class,
        ),

        new API\Post(
            validationContext: [
                'groups' => [DataEntryGroupEnum::POST],
            ],
            denormalizationContext: [
                'groups' => [DataEntryGroupEnum::POST],
            ],
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::POST],
            ],
            processor: DataEntryCreateProcessor::class,
        ),

        new API\Patch(
            validationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
            denormalizationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::PATCH],
            ],
            processor: DataEntryUpdateProcessor::class,
            provider: DataEntryItemProvider::class,
        ),

        new API\Delete(
            provider: DataEntryItemProvider::class,
            processor: DataEntryDeleteProcessor::class,
        ),
    ],
)]
class DataEntryResource
{
    /**
     * @param MetaColumnResource[] $columns
     */
    public function __construct(
        #[
            API\ApiProperty(
                identifier: true,
                readable: true,
                openapiContext: [
                    'type' => 'string',
                    'maxLength' => 255,
                ],
                required: true,
            ),
            Assert\NotBlank(groups: [DataEntryGroupEnum::POST]),
            Groups([
                DataEntryGroupEnum::GET_COLLECTION,
                DataEntryGroupEnum::POST,
                DataEntryGroupEnum::PATCH,
                DatasetGroupEnum::GET,
            ]),
        ]
        public ?string $slug = null,

        #[
            Assert\NotBlank(groups: [DataEntryGroupEnum::POST, DataEntryGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'maxLength' => 255,
                ],
            ),
            Groups([
                DataEntryGroupEnum::GET_COLLECTION,
                DataEntryGroupEnum::POST,
                DataEntryGroupEnum::PATCH,
                DatasetGroupEnum::GET,
            ]),
        ]
        public ?string $title = null,

        #[
            Assert\NotBlank(groups: [DataEntryGroupEnum::POST, DataEntryGroupEnum::PATCH]),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'maxLength' => 255,
                ],
            ),
            Groups([
                DataEntryGroupEnum::GET_COLLECTION,
                DataEntryGroupEnum::POST,
                DataEntryGroupEnum::PATCH,
            ]),
        ]
        public ?string $schemaName = null,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'maxLength' => 255,
                ],
            ),
            Assert\NotBlank(groups: [DataEntryGroupEnum::POST, DataEntryGroupEnum::PATCH]),
            Groups([
                DataEntryGroupEnum::GET_COLLECTION,
                DataEntryGroupEnum::POST,
                DataEntryGroupEnum::PATCH,
            ]),
        ]
        public ?string $tableName = null,

        #[
            Groups([
                DataEntryGroupEnum::GET,
                DatasetGroupEnum::GET,
            ])
        ]
        public array $columns = [],

        #[
            Assert\NotBlank(groups: [DataEntryGroupEnum::POST]),
            Groups([
                DataEntryGroupEnum::GET_COLLECTION,
                DataEntryGroupEnum::POST,
            ]),
        ]
        public ?DatasetResource $dataset = null,

        #[Groups([DataEntryGroupEnum::GET])]
        public ?\DateTimeInterface $updatedAt = null,

        #[Groups([DataEntryGroupEnum::GET])]
        public ?\DateTimeInterface $createdAt = null,
    ) {
    }

    public static function fromDomain(DataEntry $dataEntry): self
    {
        return new self(
            slug: $dataEntry->slug()->value,
            title: $dataEntry->title()->value,
            schemaName: $dataEntry->schemaName()->value,
            tableName: $dataEntry->tableName()->value,
            createdAt: $dataEntry->createdAt()->value,
            updatedAt: $dataEntry->updatedAt()->value,
            columns: MetaColumnResource::fromArrayDomain($dataEntry->metaColumns()->toArray()),
        );
    }

    /**
     * @param DataEntry[] $dataEntries
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $dataEntries): array
    {
        return \array_map(
            fn (DataEntry $dataEntry) => self::fromDomain($dataEntry),
            $dataEntries,
        );
    }

    public function addColumn(MetaColumnResource $column): self
    {
        $this->columns[] = $column;

        return $this;
    }
}
