<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Dataviz\Model\DataEntry;
use App\Presentation\Dataviz\Enum\DataEntryGroupEnum;
use App\Presentation\Dataviz\Enum\DatasetGroupEnum;
use App\Presentation\Dataviz\State\Provider\DataEntryCollectionProvider;
use App\Presentation\Dataviz\State\Provider\DataEntryItemProvider;
use App\Presentation\Dataviz\State\Provider\TableCollectionProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'DataEntry',
    operations: [
        new API\GetCollection(
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::GET_COLLECTION],
            ],
            provider: DataEntryCollectionProvider::class,
        ),

        new API\GetCollection(
            uriTemplate: '/data-entry/{slug}/table',
            provider: TableCollectionProvider::class,
            output: \stdClass::class,
        ),

        new API\Get(
            normalizationContext: [
                'groups' => [DataEntryGroupEnum::GET_COLLECTION, DataEntryGroupEnum::GET],
            ],
            provider: DataEntryItemProvider::class,
        ),
    ],
)]
class DataEntryResource
{
    /**
     * @param MetaColumnResource[] $columns
     */
    public function __construct(
        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION, DatasetGroupEnum::GET])]
        public string $slug,

        #[API\ApiProperty(required: true)]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION, DatasetGroupEnum::GET])]
        public string $title,

        #[API\ApiProperty(required: true)]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION])]
        public string $schemaName,

        #[API\ApiProperty(required: true)]
        #[Groups([DataEntryGroupEnum::GET_COLLECTION])]
        public string $tableName,

        #[Groups([DataEntryGroupEnum::GET, DatasetGroupEnum::GET])]
        public array $columns,

        #[API\ApiProperty(required: true)]
        #[Groups([DataEntryGroupEnum::GET])]
        public \DateTimeInterface $updatedAt,

        #[API\ApiProperty(required: true)]
        #[Groups([DataEntryGroupEnum::GET])]
        public \DateTimeInterface $createdAt,
    ) {
    }

    public static function fromDomain(DataEntry $dataEntry): self
    {
        return new self(
            slug: $dataEntry->slug()->value,
            title: $dataEntry->title()->value,
            schemaName: $dataEntry->schemaName()->value,
            tableName: $dataEntry->tableName()->value,
            columns: MetaColumnResource::fromArrayDomain($dataEntry->metaColumns()->toArray()),
            createdAt: $dataEntry->createdAt()->value,
            updatedAt: $dataEntry->updatedAt()->value,
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
