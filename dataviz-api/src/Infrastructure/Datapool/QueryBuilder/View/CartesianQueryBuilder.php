<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\View;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Infrastructure\Datapool\QueryBuilder\Skeleton\AbstractViewQueryBuilder;
use Aura\SqlQuery\Common\SelectInterface;

class CartesianQueryBuilder extends AbstractViewQueryBuilder
{
    public function supports(ViewEnum $view): bool
    {
        return ViewEnum::CARTESIAN === $view;
    }

    public function process(SelectInterface $select): void
    {
        $cols = [
            $this->colRepartition($this->request->axisDistribution()) => 'x',
            $this->colAggregateOperation($this->request->axisOperation()) => 'y',
        ];

        $group = ['"x"'];

        if ($this->request->hasSerie()) {
            $cols[$this->request->serie()->fullColumnName()] = 'serie';
            $group[] = '"serie"';
        }

        $select->cols($cols)->groupBy($group)->orderBy($group);

        $this->bindWhere($select);
    }
}
