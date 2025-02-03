<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Payload\Chart\Components;

use ApiPlatform\Metadata as API;
use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use Symfony\Component\Validator\Constraints as Assert;

class AxisDistributionPayload
{
    public const OPERATION_TYPE = [
        OperationTypeEnum::BY_MONTH->value,
        OperationTypeEnum::BY_DAY->value,
        OperationTypeEnum::BY_DAY_OF_THE_WEEK->value,
        OperationTypeEnum::BY_HOUR->value,
        OperationTypeEnum::YEARLY->value,
        OperationTypeEnum::MONTHLY->value,
        OperationTypeEnum::DAILY->value,
    ];

    public function __construct(
        #[
            Assert\NotBlank(),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'example' => 'agepyr10',
                ],
                required: true,
            )
        ]
        public string $column,

        #[
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'example' => 'pop1a',
                    'description' => 'This field is only useful when the base is made up of several tables, otherwise it will be ignored.',
                ],
            )
        ]
        public ?string $dataEntry = null,

        #[
            Assert\Choice(choices: self::OPERATION_TYPE),
            API\ApiProperty(
                openapiContext: [
                    'type' => 'string',
                    'enum' => self::OPERATION_TYPE,
                    'description' => 'This field is only useful when the colum is of date type, otherwise it will be ignored.',
                ],
            )
        ]
        public ?string $dateOperation = null,
    ) {
    }

    public static function toDomain(self $payload): AxisDistribution
    {
        return new AxisDistribution(
            column: new MetaColumnColumnName($payload->column),
            dataEntrySlug: null !== $payload->dataEntry ? new DataEntrySlug($payload->dataEntry) : null,
            dateOperation: null !== $payload->dateOperation ? OperationTypeEnum::from($payload->dateOperation) : null,
        );
    }
}
