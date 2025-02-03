<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use App\Domain\Datapool\Model\AdministrativeDivision\Municipality;

class MunicipalityResource
{
    public function __construct(
        public int $year,

        public string $codgeo,

        public string $label,

        public string $typecom,
    ) {
    }

    public static function fromDomain(Municipality $model): self
    {
        return new self(
            year: $model->year()->value,
            codgeo: $model->codgeo()->value,
            label: $model->label()->value,
            typecom: $model->typecom()->value,
        );
    }

    /**
     * @return self[]
     */
    public static function fromArrayDomain(array $models): array
    {
        return \array_map(
            fn (Municipality $model) => self::fromDomain($model),
            $models,
        );
    }
}
