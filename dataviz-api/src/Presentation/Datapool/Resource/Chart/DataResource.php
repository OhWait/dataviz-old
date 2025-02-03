<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\Chart;

use App\Domain\Datapool\Model\Chart\Data;
use App\Presentation\Datapool\Enum\ChartGroupEnum;
use Symfony\Component\Serializer\Annotation\Groups;

class DataResource
{
    public function __construct(
        #[Groups([ChartGroupEnum::CARTESIAN])]
        public int|float|string|null $x,

        #[Groups([ChartGroupEnum::CHART])]
        public float $y,

        #[Groups([ChartGroupEnum::CHART])]
        public ?string $label,
    ) {
    }

    public static function fromDomain(Data $data): self
    {
        return new self(
            label: $data->label(),
            x: $data->x(),
            y: $data->y(),
        );
    }
}
