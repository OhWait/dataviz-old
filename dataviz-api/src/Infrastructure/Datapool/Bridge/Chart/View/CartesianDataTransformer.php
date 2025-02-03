<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart\View;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use App\Infrastructure\Datapool\Bridge\Chart\Component\SerieDataTransformer;
use App\Infrastructure\Datapool\Bridge\Chart\QueryDataTransformer;
use App\Infrastructure\Datapool\Bridge\Chart\Skeleton\ChartDataTransformerInterface;
use App\Shared\Infrastructure\Bridge\PropertyAccessor;
use App\Shared\Infrastructure\Bridge\ViewDataTransformerTrait;
use Aura\SqlQuery\Common\SelectInterface;

class CartesianDataTransformer implements ChartDataTransformerInterface
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
        return ViewEnum::CARTESIAN === $view;
    }

    public function transform(array $data, SelectInterface $query, Request $request): Chart
    {
        return new Chart(
            query: $this->queryDataTransformer->toDomain($query),
            series: \array_map(
                fn (array $d) => $this->serieDataTransformer->toDomain($d),
                $this->toSerie($data, $request),
            ),
        );
    }

    private function toSerie(array $data, Request $request): array
    {
        $dataFormatted = [];

        foreach ($data as $row) {
            $nameSerie = $this->propertyAccessor->toString($row, '[serie]', 'serie');

            $dataFormatted[$nameSerie]['data'][] = [
                'y' => $this->propertyAccessor->toFloat($row, '[y]'),
                'x' => $this->propertyAccessor->toStringOrNull($row, '[x]'),
                'label' => $this->label($request->axisDistribution(), $row, 'x'),
            ];

            if ($request->hasSerie()) {
                $dataFormatted[$nameSerie]['label'] = $this->label($request->serie(), $row, 'serie');
            }
        }

        return \array_values($dataFormatted);
    }
}
