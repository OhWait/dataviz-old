<?php

declare(strict_types=1);

namespace App\Domain\Datapool\UseCase\Chart;

use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Shared\Domain\Enum\ViolationTypeEnum;
use App\Shared\Domain\Model\RequestColumnInterface;
use App\Shared\Domain\UseCase\Validator\AbstractValidator;
use Zenstruck\Foundry\Test\Factories;

/**
 * ColumnsValidator is a simple class for validating the parameters of a request before processing it into database.
 *
 * ColumnsValidator is a class exists to validate and help provide people with an understanding
 * as to how their request contains mistakes.
 *
 * @author Maxime <maxime.preuilh@gmail.com>
 */
class ColumnsValidator extends AbstractValidator
{
    use Factories;

    public function __construct(private readonly Dataset $dataset)
    {
    }

    /**
     * @param RequestColumnInterface[] $params
     */
    public function process(array $params): void
    {
        foreach ($params as $propertyPath => $param) {
            $this->checkColumn($param, $propertyPath);
        }
    }

    private function checkColumn(
        RequestColumnInterface $ask,
        string $propertyPath,
    ): void {
        if (null === $ask->dataEntry()) {
            $this->addDataEntryViolation($ask, $propertyPath);

            return;
        }

        $column = $ask
            ->dataEntry()
            ->metaColumns()
            ->findFirst(function (int $key, MetaColumn $column) use ($ask) {
                return $ask->column()->equals($column->columnName());
            });

        if (null === $column) {
            $this->addMetaColumnViolation($ask, $propertyPath);
        }
    }

    private function addDataEntryViolation(
        RequestColumnInterface $ask,
        string $propertyPath,
    ): void {
        $authorizedValues = \array_map(
            fn (DataEntry $dataEntry) => $dataEntry->slug()->value,
            $this->dataset->dataEntries()->toArray(),
        );

        $this->addViolationWithAllowedValues(
            authorizedValues: $authorizedValues,
            fullPropertyPath: "{$propertyPath}.dataEntry",
            type: ViolationTypeEnum::ERROR,
            invalidValue: $ask->column()->value,
        );
    }

    private function addMetaColumnViolation(
        RequestColumnInterface $ask,
        string $propertyPath,
    ): void {
        $authorizedValues = \array_map(
            fn (MetaColumn $metaColumn) => $metaColumn->columnName()->value,
            $ask->dataEntry()->metaColumns()->toArray(),
        );

        $this->addViolationWithAllowedValues(
            authorizedValues: $authorizedValues,
            fullPropertyPath: "{$propertyPath}.column",
            type: ViolationTypeEnum::ERROR,
            invalidValue: $ask->column()->value,
        );
    }
}
