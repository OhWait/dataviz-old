<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\Chart\Request;

use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Shared\Domain\Model\ColumnChartTrait;
use App\Shared\Domain\Model\RequestColumnInterface;
use App\Shared\Domain\Model\RequestColumnOverrideInterface;

class Serie implements RequestColumnInterface, RequestColumnOverrideInterface
{
    use ColumnChartTrait;

    public function __construct(
        protected MetaColumnColumnName $column,
        protected ?DataEntrySlug $dataEntrySlug,
    ) {
    }
}
