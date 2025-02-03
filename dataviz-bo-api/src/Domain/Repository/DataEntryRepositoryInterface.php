<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\DataEntry;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<DataEntry>
 */
interface DataEntryRepositoryInterface extends RepositoryInterface
{
}
