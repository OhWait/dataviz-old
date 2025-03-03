<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\View;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Infrastructure\Datapool\QueryBuilder\Skeleton\AbstractViewQueryBuilder;
use Aura\SqlQuery\Common\SelectInterface;

class PolarQueryBuilder extends AbstractViewQueryBuilder
{
    public function supports(ViewEnum $view): bool
    {
        return ViewEnum::POLAR === $view;
    }

    public function process(SelectInterface $select): void
    {
        $select->cols([$this->colAggregateOperation($this->request->values()) => 'y']);

        if ($this->request->hasSerie()) {
            $select
                ->cols([$this->request->serie()->fullColumnName() => 'serie'])
                ->groupBy(['"serie"'])
                ->orderBy(['"serie"']);
        }

        $this->bindWhere($select);
    }
}
