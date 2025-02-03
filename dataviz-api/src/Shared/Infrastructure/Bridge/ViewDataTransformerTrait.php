<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bridge;

use App\Domain\Dataviz\Model\MetaRow;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowValue;
use App\Shared\Domain\Model\RequestColumnInterface;

trait ViewDataTransformerTrait
{
    private function label(RequestColumnInterface $param, array $row, string $propertyPath): string
    {
        $nameSerie = $this->propertyAccessor->toString(
            $row,
            sprintf('[%s]', $propertyPath),
            'serie',
        );

        $label = $param->meta()?->metaRows()->findFirst(function (int $index, MetaRow $row) use ($nameSerie) {
            return $row->value()->equals(new MetaRowValue($nameSerie));
        })?->label()->value;

        return null !== $label ? $label : $nameSerie;
    }
}
