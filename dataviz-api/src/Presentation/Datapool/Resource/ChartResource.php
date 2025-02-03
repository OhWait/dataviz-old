<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource;

use ApiPlatform\Metadata as API;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Serie;
use App\Presentation\Datapool\Enum\ChartGroupEnum;
use App\Presentation\Datapool\Payload\Chart\View\CartesianPayload;
use App\Presentation\Datapool\Payload\Chart\View\PolarPayload;
use App\Presentation\Datapool\Resource\Chart\QueryResource;
use App\Presentation\Datapool\Resource\Chart\SerieResource;
use App\Presentation\Datapool\State\Processor\CartesianProcessor;
use App\Presentation\Datapool\State\Processor\PolarProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'Chart',
    operations: [
        new API\Post(
            normalizationContext: [
                'groups' => [ChartGroupEnum::CARTESIAN, ChartGroupEnum::CHART],
            ],
            uriTemplate: '/chart/{slug}/cartesian.{_format}',
            processor: CartesianProcessor::class,
            input: CartesianPayload::class,
            formats: ['json'],
        ),

        new API\Post(
            normalizationContext: [
                'groups' => [ChartGroupEnum::POLAR, ChartGroupEnum::CHART],
            ],
            uriTemplate: '/chart/{slug}/polar.{_format}',
            processor: PolarProcessor::class,
            input: PolarPayload::class,
            formats: ['json'],
        ),
    ],
)]
class ChartResource
{
    /**
     * @param SerieResource[] $series
     */
    public function __construct(
        #[Groups([ChartGroupEnum::CHART])]
        public array $series,

        #[Groups([ChartGroupEnum::CHART])]
        public QueryResource $query,
    ) {
    }

    public function addSeries(SerieResource $serieResource): self
    {
        $this->series[] = $serieResource;

        return $this;
    }

    public static function fromDomain(Chart $chart): self
    {
        return new self(
            series: \array_map(
                fn (Serie $serie) => SerieResource::fromDomain($serie),
                $chart->series(),
            ),
            query: QueryResource::fromDomain($chart->query()),
        );
    }
}
