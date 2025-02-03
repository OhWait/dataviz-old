<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Resource\AdministrativeDivision;

use App\Domain\Datapool\Model\AdministrativeDivision\Piic;

class PiicResource
{
    public function __construct(
        public int $year,

        public string $codepiic,

        public string $label,

        public string $nature,
    ) {
    }

    public static function fromDomain(Piic $model): self
    {
        return new self(
            year: $model->year()->value,
            codepiic: $model->code()->value,
            label: $model->label()->value,
            nature: $model->nature()->value,
        );
    }

    /**
     * @return self[]
     */
    public static function fromArrayDomain(array $models): array
    {
        return \array_map(
            fn (Piic $model) => self::fromDomain($model),
            $models,
        );
    }
}
