<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Payload\Chart\View;

use ApiPlatform\Metadata as API;
use App\Presentation\Datapool\Payload\Chart\Components\AxisDistributionPayload;
use App\Presentation\Datapool\Payload\Chart\Components\AxisOperationPayload;
use App\Presentation\Datapool\Payload\Chart\Components\FilterPayload;
use App\Presentation\Datapool\Payload\Chart\Components\SeriePayload;
use Symfony\Component\Validator\Constraints as Assert;

class CartesianPayload
{
    /**
     * @param FilterPayload[] $filters
     */
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Valid()]
        public AxisDistributionPayload $distribution,

        #[Assert\NotBlank()]
        #[Assert\Valid()]
        public AxisOperationPayload $operation,

        #[Assert\Valid()]
        #[API\ApiProperty(required: false)]
        public ?SeriePayload $serie = null,

        #[Assert\Valid()]
        public array $filters = [],
    ) {
    }

    public function addFilter(FilterPayload $filter): self
    {
        $this->filters[] = $filter;

        return $this;
    }
}
