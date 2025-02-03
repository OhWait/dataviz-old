<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart;

use App\Domain\Datapool\Model\Chart\Query;
use Aura\SqlQuery\Common\SelectInterface;

class QueryDataTransformer
{
    public function toDomain(SelectInterface $query): Query
    {
        return new Query(
            statement: $query->getStatement(),
            bindValues: $query->getBindValues(),
        );
    }
}
