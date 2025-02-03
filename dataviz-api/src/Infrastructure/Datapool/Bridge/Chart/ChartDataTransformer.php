<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use App\Infrastructure\Datapool\Bridge\Chart\Skeleton\ChartDataTransformerFactory;
use Aura\SqlQuery\Common\SelectInterface;

class ChartDataTransformer
{
    public function __construct(private readonly ChartDataTransformerFactory $dataTransformerFactory)
    {
    }

    public function toDomain(array $data, ViewEnum $view, SelectInterface $query, Request $request): Chart
    {
        return $this->dataTransformerFactory
            ->getDataTransformer($view)
            ->transform($data, $query, $request);
    }
}
