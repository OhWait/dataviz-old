<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Repository;

use App\Domain\Dataviz\Model\Dataset;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Dataset>
 */
interface DatasetRepositoryInterface extends RepositoryInterface
{
    public function findWithMeta(string $slug): ?Dataset;
}
