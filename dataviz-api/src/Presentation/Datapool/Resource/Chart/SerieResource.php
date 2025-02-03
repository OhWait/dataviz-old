<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\Chart;

use App\Domain\Datapool\Model\Chart\Data;
use App\Domain\Datapool\Model\Chart\Serie;
use App\Presentation\Datapool\Enum\ChartGroupEnum;
use Symfony\Component\Serializer\Annotation\Groups;

class SerieResource
{
    /**
     * @param DataResource[] $data
     */
    public function __construct(
        #[Groups([ChartGroupEnum::CHART])]
        public array $data,

        #[Groups([ChartGroupEnum::CARTESIAN])]
        public ?string $label = null,
    ) {
    }

    public function addData(DataResource $data): self
    {
        $this->data[] = $data;

        return $this;
    }

    public static function fromDomain(Serie $serie): self
    {
        return new self(
            label: $serie->label(),
            data: \array_map(
                fn (Data $data) => DataResource::fromDomain($data),
                $serie->data(),
            ),
        );
    }
}
