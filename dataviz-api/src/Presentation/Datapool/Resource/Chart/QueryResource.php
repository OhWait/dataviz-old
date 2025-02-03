<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\Chart;

use ApiPlatform\Metadata as API;
use App\Domain\Datapool\Model\Chart\Query;
use App\Presentation\Datapool\Enum\ChartGroupEnum;
use Symfony\Component\Serializer\Annotation\Groups;

#[API\ApiResource(
    shortName: 'Query',
    operations: [],
)]
class QueryResource
{
    public function __construct(
        #[Groups([ChartGroupEnum::CHART])]
        public string $statement,

        #[Groups([ChartGroupEnum::CHART])]
        public array $bindValues,
    ) {
    }

    public static function fromDomain(Query $query): self
    {
        return new self(
            statement: $query->statement(),
            bindValues: $query->bindValues(),
        );
    }
}
