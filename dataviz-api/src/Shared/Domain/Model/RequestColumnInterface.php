<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;

interface RequestColumnInterface
{
    public function dataEntrySlug(): ?DataEntrySlug;

    public function dataEntry(): ?DataEntry;

    public function meta(): ?MetaColumn;

    public function column(): ?MetaColumnColumnName;
}
