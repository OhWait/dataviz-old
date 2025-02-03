<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Payload\Chart\Components;

use ApiPlatform\Metadata as API;
use App\Domain\Datapool\Model\Chart\Request\Serie;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use Symfony\Component\Validator\Constraints as Assert;

class SeriePayload
{
    public function __construct(
        #[Assert\NotBlank()]
        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'example' => 'sexe',
            ],
            required: true,
        )]
        public string $column,

        #[Assert\Type('string')]
        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'example' => 'pop1a',
            ],
        )]
        public ?string $dataEntry = null,
    ) {
    }

    public static function toDomain(self $payload): Serie
    {
        return new Serie(
            column: new MetaColumnColumnName($payload->column),
            dataEntrySlug: null !== $payload->dataEntry ? new DataEntrySlug($payload->dataEntry) : null,
        );
    }
}
