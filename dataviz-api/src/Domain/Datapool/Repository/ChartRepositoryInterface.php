<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Repository;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Dataviz\Model\Dataset;

interface ChartRepositoryInterface
{
    public function getChart(Dataset $dataset, ViewEnum $view, Request $request): ?Chart;
}
