<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use App\Domain\Datapool\Model\AdministrativeDivision\Department;

class DepartmentResource
{
    public function __construct(
        public int $year,

        public string $codedep,

        public string $label,
    ) {
    }

    public static function fromDomain(Department $model): self
    {
        return new self(
            year: $model->year()->value,
            codedep: $model->code()->value,
            label: $model->label()->value,
        );
    }

    /**
     * @param Department[] $models
     *
     * @return self[]
     */
    public static function fromArrayDomain(array $models): array
    {
        return \array_map(
            fn (Department $model) => self::fromDomain($model),
            $models,
        );
    }
}
