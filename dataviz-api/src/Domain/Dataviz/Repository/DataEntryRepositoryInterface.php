<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Repository;

use App\Domain\Dataviz\Model\DataEntry;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<DataEntry>
 */
interface DataEntryRepositoryInterface extends RepositoryInterface
{
}
