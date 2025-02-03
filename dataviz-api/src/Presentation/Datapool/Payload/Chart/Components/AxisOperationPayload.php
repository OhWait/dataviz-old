<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Payload\Chart\Components;

use ApiPlatform\Metadata as API;
use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use Symfony\Component\Validator\Constraints as Assert;

class AxisOperationPayload
{
    public const OPERATION_TYPE = [
        OperationTypeEnum::SUM->value,
        OperationTypeEnum::COUNT->value,
        OperationTypeEnum::COUNT_DISTINCT->value,
    ];

    public function __construct(
        #[Assert\NotBlank()]
        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'example' => 'nb',
            ],
            required: true,
        )]
        public string $column,

        #[Assert\NotBlank()]
        #[Assert\Choice(choices: self::OPERATION_TYPE)]
        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'enum' => self::OPERATION_TYPE,
            ],
            required: true,
        )]
        public string $operation,

        #[API\ApiProperty(
            openapiContext: [
                'type' => 'string',
                'example' => 'pop1a',
            ],
        )]
        public ?string $dataEntry = null,
    ) {
    }

    public static function toDomain(self $payload): AxisOperation
    {
        return new AxisOperation(
            column: new MetaColumnColumnName($payload->column),
            operationType: OperationTypeEnum::from($payload->operation),
            dataEntrySlug: null !== $payload->dataEntry ? new DataEntrySlug($payload->dataEntry) : null,
        );
    }
}
