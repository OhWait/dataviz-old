<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Dataset;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Dataset>
 */
interface DatasetRepositoryInterface extends RepositoryInterface
{
}
