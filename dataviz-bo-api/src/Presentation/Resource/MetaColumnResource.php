<?php

declare(strict_types=1);

namespace App\Presentation\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Model\MetaColumn;
use App\Presentation\Enum\DataEntryGroupEnum;
use App\Presentation\Enum\DatasetGroupEnum;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'MetaColumn',
    // security: "is_granted('ROLE_ADMIN')",
    operations: [],
)]
class MetaColumnResource
{
    /**
     * @param MetaRowResource[] $values
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
            Groups([
                DataEntryGroupEnum::GET,
                DatasetGroupEnum::GET,
            ])
        ]
        public string $columnName,

        #[Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])]
        public bool $isNullable,

        #[Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])]
        public string $dataType,

        #[Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])]
        public ?int $characterMaximumLength,

        #[Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])]
        public ?string $label,

        #[Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])]
        public array $values,
    ) {
    }

    public static function fromDomain(MetaColumn $column): self
    {
        return new MetaColumnResource(
            columnName: $column->columnName()->value,
            isNullable: $column->nullable()->value,
            dataType: $column->dataType()->value(),
            characterMaximumLength: $column->characterMaximumLength()->value,
            label: $column->label()->value,
            values: MetaRowResource::fromArrayDomain($column->metaRows()->toArray()),
        );
    }

    /**
     * @param MetaColumn[] $columns
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $columns): array
    {
        return \array_map(
            fn (MetaColumn $metaColumn) => self::fromDomain($metaColumn),
            $columns,
        );
    }

    public function addValue(MetaRowResource $metaRow): self
    {
        $this->values[] = $metaRow;

        return $this;
    }
}
