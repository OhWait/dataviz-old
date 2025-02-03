<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Skeleton;

use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Domain\Dataviz\Model\Dataset;

class ProviderQueryBuilderFactory
{
    /**
     * @param ProviderQueryBuilderInterface[] $builders
     */
    public function __construct(private iterable $builders)
    {
    }

    public function getBuilder(DataProviderEnum $provider, Dataset $dataset, Request $request): ProviderQueryBuilderInterface
    {
        foreach ($this->builders as $query) {
            if ($query->supports($provider)) {
                return $query->setDataset($dataset)->setRequest($request);
            }
        }

        throw new \Exception();
    }
}
