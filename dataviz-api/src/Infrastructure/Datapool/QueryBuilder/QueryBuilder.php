<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Model\Dataset;
use App\Infrastructure\Datapool\QueryBuilder\Skeleton\ProviderQueryBuilderFactory;
use App\Infrastructure\Datapool\QueryBuilder\Skeleton\ViewQueryBuilderFactory;
use Aura\SqlQuery\Common\SelectInterface;
use Aura\SqlQuery\QueryFactory;

class QueryBuilder
{
    public function __construct(
        private readonly ViewQueryBuilderFactory $viewsBuilder,
        private readonly ProviderQueryBuilderFactory $providersBuilder,
    ) {
    }

    public function process(
        ViewEnum $view,
        Dataset $dataset,
        Request $request,
    ): SelectInterface {
        $select = (new QueryFactory('pgsql'))->newSelect();

        $this->viewsBuilder
            ->getBuilder($view, $dataset, $request)
            ->process($select);

        $this->providersBuilder
            ->getBuilder($dataset->dataProvider()->value, $dataset, $request)
            ->process($select);

        return $select;
    }
}
