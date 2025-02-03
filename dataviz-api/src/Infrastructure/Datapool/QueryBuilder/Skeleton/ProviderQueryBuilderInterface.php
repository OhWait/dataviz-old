<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Skeleton;

use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Domain\Dataviz\Model\Dataset;
use Aura\SqlQuery\Common\SelectInterface;

interface ProviderQueryBuilderInterface
{
    public function supports(DataProviderEnum $provider): bool;

    public function process(SelectInterface $select): void;

    public function setDataset(Dataset $dataset): self;

    public function setRequest(Request $request): self;
}
