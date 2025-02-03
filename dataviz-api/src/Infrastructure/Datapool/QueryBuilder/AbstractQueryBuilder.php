<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder;

use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\Model\Chart\Request\AxisDistribution;
use App\Domain\Datapool\Model\Chart\Request\AxisOperation;
use App\Domain\Dataviz\Model\Dataset;
use Aura\SqlQuery\Common\SelectInterface;

abstract class AbstractQueryBuilder
{
    protected Dataset $dataset;
    protected Request $request;

    protected function colAggregateOperation(AxisOperation $column): string
    {
        return \sprintf(
            OperationTypeEnum::toOperation($column->operationType()),
            $column->fullColumnName(),
        );
    }

    protected function colRepartition(AxisDistribution $axis): string
    {
        if ($axis->dateOperation()) {
            return \sprintf(
                OperationTypeEnum::toAggregateDate($axis->dateOperation()),
                $axis->fullColumnName(),
            );
        }

        return $axis->fullColumnName();
    }

    protected function defaultFrom(): string
    {
        $tableEntry = $this->request->dataEntries()->first();

        return sprintf(
            '%s as %s',
            $tableEntry->fullTableName(),
            $tableEntry->tableName(),
        );
    }

    protected function bindWhere(SelectInterface $select): void
    {
        foreach ($this->request->filters()->toArray() as $filter) {
            $select->where(
                $filter->whereCond(),
                $filter->whereBind(),
            );
        }
    }
}
