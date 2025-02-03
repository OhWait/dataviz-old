<?php

declare(strict_types=1);

namespace App\Presentation\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Model\MetaRow;
use App\Presentation\Enum\DataEntryGroupEnum;
use App\Presentation\Enum\DatasetGroupEnum;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'MetaValue',
    // security: "is_granted('ROLE_ADMIN')",
    operations: [],
)]
class MetaRowResource
{
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
        public string $value,

        #[Groups([
            DataEntryGroupEnum::GET,
            DatasetGroupEnum::GET,
        ])]
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
