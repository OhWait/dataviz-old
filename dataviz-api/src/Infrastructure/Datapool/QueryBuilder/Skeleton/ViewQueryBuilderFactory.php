<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Skeleton;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Model\Dataset;

class ViewQueryBuilderFactory
{
    /**
     * @param ViewQueryBuilderInterface[] $builders
     */
    public function __construct(private iterable $builders)
    {
    }

    public function getBuilder(ViewEnum $view, Dataset $dataset, Request $request): ViewQueryBuilderInterface
    {
        foreach ($this->builders as $query) {
            if ($query->supports($view)) {
                return $query->setDataset($dataset)->setRequest($request);
            }
        }

        throw new \Exception();
    }
}
