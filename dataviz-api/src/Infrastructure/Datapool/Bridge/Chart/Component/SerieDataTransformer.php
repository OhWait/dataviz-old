<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart\Component;

use App\Domain\Datapool\Model\Chart\Serie;
use App\Shared\Infrastructure\Bridge\PropertyAccessor;

class SerieDataTransformer
{
    public function __construct(
        private readonly PropertyAccessor $propertyAccessor,
        private readonly DataDataTransformer $dataDataTransformer,
    ) {
    }

    public function toDomain(array $data): Serie
    {
        return new Serie(
            label: $this->propertyAccessor->toStringOrNull($data, '[label]'),
            data: \array_map(
                fn (array $d) => $this->dataDataTransformer->toDomain($d),
                $this->propertyAccessor->toArray($data, '[data]'),
            ),
        );
    }
}
