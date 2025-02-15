<?php

declare(strict_types=1);

namespace App\Presentation\Dataviz\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Dataviz\Model\MetaRow;
use App\Presentation\Dataviz\Enum\DataEntryGroupEnum;
use App\Presentation\Dataviz\Enum\DatasetGroupEnum;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'MetaValue',
    operations: [],
)]
class MetaRowResource
{
    public function __construct(
        #[API\ApiProperty(identifier: true, required: true)]
        #[Groups([DataEntryGroupEnum::GET, DatasetGroupEnum::GET])]
        public string $value,

        #[API\ApiProperty(required: true)]
        #[Groups([DataEntryGroupEnum::GET, DatasetGroupEnum::GET])]
        public string $label,
    ) {
    }

    public static function fromDomain(MetaRow $row): self
    {
        return new MetaRowResource(
            value: $row->value()->value,
            label: $row->label()->value,
        );
    }

    /**
     * @param MetaRow[] $rows
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $rows): array
    {
        return \array_map(
            fn (MetaRow $row) => self::fromDomain($row),
            $rows,
        );
    }
}
