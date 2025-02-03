<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Payload\Chart\Components;

use ApiPlatform\Metadata as API;
use App\Domain\Datapool\Model\Chart\Filter;
use App\Domain\Datapool\ValueObject\Chart\FilterValue;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use Symfony\Component\Validator\Constraints as Assert;

class FilterPayload
{
    /**
     * @param string[] $values
     */
    public function __construct(
        #[Assert\NotBlank()]
        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'example' => 'millesime',
            ],
            required: true,
        )]
        public string $column,

        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'example' => 'pop1a',
            ],
        )]
        public ?string $dataEntry = null,

        #[Assert\NotBlank()]
        #[Assert\Count(min: 1)]
        #[Assert\Type('array')]
        #[API\ApiProperty(
            openapiContext: [
                'type' => 'array',
                'items' => ['type' => 'string', 'example' => '2016'],
            ],
            required: true,
        )]
        public array $values = [],
    ) {
    }

    public static function toDomain(self $payload): Filter
    {
        return new Filter(
            column: new MetaColumnColumnName($payload->column),
            dataEntrySlug: null !== $payload->dataEntry ? new DataEntrySlug($payload->dataEntry) : null,
            values: \array_map(
                fn (string $value) => new FilterValue($value),
                $payload->values,
            ),
        );
    }

    public static function toArrayDomain(array $payload): array
    {
        return \array_map(
            fn (self $filter) => self::toDomain($filter),
            $payload,
        );
    }
}
