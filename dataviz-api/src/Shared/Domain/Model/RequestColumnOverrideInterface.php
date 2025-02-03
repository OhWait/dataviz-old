<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Domain\Dataviz\Model\DataEntry;
use App\Domain\Dataviz\Model\MetaColumn;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;

interface RequestColumnOverrideInterface extends RequestColumnInterface
{
    /**
     * @return self
     */
    public function setMeta(MetaColumn $meta);

    /**
     * @return self
     */
    public function setDataEntrySlug(DataEntrySlug $dataEntrySlug);

    /**
     * @return self
     */
    public function setDataEntry(DataEntry $dataEntry);
}
