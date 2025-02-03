<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Bridge\Chart\Component;

use App\Domain\Datapool\Model\Chart\Data;
use App\Shared\Infrastructure\Bridge\PropertyAccessor;

class DataDataTransformer
{
    public function __construct(
        private readonly PropertyAccessor $propertyAccessor,
    ) {
    }

    public function toDomain(array $data): Data
    {
        return new Data(
            x: $this->propertyAccessor->value($data, '[x]'),
            y: $this->propertyAccessor->toFloat($data, '[y]'),
            label: $this->propertyAccessor->toStringOrNull($data, '[label]'),
        );
    }
}
