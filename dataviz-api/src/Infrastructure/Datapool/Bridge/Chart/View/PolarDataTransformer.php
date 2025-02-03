<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart\View;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\Model\Chart\Request\Serie;
use App\Infrastructure\Datapool\Bridge\Chart\Component\SerieDataTransformer;
use App\Infrastructure\Datapool\Bridge\Chart\QueryDataTransformer;
use App\Infrastructure\Datapool\Bridge\Chart\Skeleton\ChartDataTransformerInterface;
use App\Shared\Infrastructure\Bridge\PropertyAccessor;
use App\Shared\Infrastructure\Bridge\ViewDataTransformerTrait;
use Aura\SqlQuery\Common\SelectInterface;

class PolarDataTransformer implements ChartDataTransformerInterface
{
    use ViewDataTransformerTrait;

    public function __construct(
        private readonly PropertyAccessor $propertyAccessor,
        private readonly SerieDataTransformer $serieDataTransformer,
        private readonly QueryDataTransformer $queryDataTransformer,
    ) {
    }

    public function supports(ViewEnum $view): bool
    {
        return ViewEnum::POLAR === $view;
    }

    public function transform(array $data, SelectInterface $query, Request $request): Chart
    {
        return new Chart(
            query: $this->queryDataTransformer->toDomain($query),
            series: $this->toSerie($data, $request),
        );
    }

    /**
     * @return Serie[]
     */
    private function toSerie(array $data, Request $request): array
    {
        $dataFormatted = [];

        foreach ($data as $slice) {
            $dataFormatted['data'][] = [
                'y' => $this->propertyAccessor->toFloat($slice, '[y]'),
                'label' => $this->label($request->serie(), $slice, 'serie'),
            ];
        }

        return [$this->serieDataTransformer->toDomain($dataFormatted)];
    }
}
