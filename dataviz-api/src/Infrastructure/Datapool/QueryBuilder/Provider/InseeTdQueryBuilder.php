<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Provider;

use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Infrastructure\Datapool\QueryBuilder\Skeleton\AbstractProviderQueryBuilder;
use Aura\SqlQuery\Common\SelectInterface;

class InseeTdQueryBuilder extends AbstractProviderQueryBuilder
{
    public function supports(DataProviderEnum $provider): bool
    {
        return DataProviderEnum::INSEE_TD === $provider;
    }

    public function process(SelectInterface $select): void
    {
        $select->from($this->defaultFrom());
    }
}
