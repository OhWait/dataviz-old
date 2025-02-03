<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\QueryBuilder\Skeleton;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Model\Dataset;
use Aura\SqlQuery\Common\SelectInterface;

interface ViewQueryBuilderInterface
{
    public function supports(ViewEnum $view): bool;

    public function setDataset(Dataset $dataset): self;

    public function setRequest(Request $request): self;

    public function process(SelectInterface $select): void;
}
