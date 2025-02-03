<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Skeleton;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Model\Dataset;
use App\Infrastructure\Datapool\QueryBuilder\AbstractQueryBuilder;

abstract class AbstractViewQueryBuilder extends AbstractQueryBuilder implements ViewQueryBuilderInterface
{
    abstract public function supports(ViewEnum $view): bool;

    public function setDataset(Dataset $dataset): self
    {
        $this->dataset = $dataset;

        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }
}
