<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart\Skeleton;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use Aura\SqlQuery\Common\SelectInterface;

interface ChartDataTransformerInterface
{
    public function supports(ViewEnum $view): bool;

    public function transform(
        array $data,
        SelectInterface $query,
        Request $request,
    ): Chart;
}
