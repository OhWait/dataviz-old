<?php

declare(strict_types=1);

namespace App\Infrastructure\Datapool\Repository;

use App\Domain\Datapool\Enum\Chart\ViewEnum;
use App\Domain\Datapool\Model\Chart;
use App\Domain\Datapool\Model\Chart\Request;
use App\Domain\Datapool\Repository\ChartRepositoryInterface;
use App\Domain\Dataviz\Model\Dataset;
use App\Infrastructure\Datapool\Bridge\Chart\ChartDataTransformer;
use App\Infrastructure\Datapool\QueryBuilder\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class ChartRepository extends DatapoolRepository implements ChartRepositoryInterface
{
    public function __construct(
        protected ManagerRegistry $em,
        private readonly LoggerInterface $loggerInterface,
        private readonly CacheInterface $cache,
        private readonly QueryBuilder $queryBuilder,
        private readonly ChartDataTransformer $chartDataTransformer,
    ) {
        parent::__construct($em);
    }

    public function getChart(Dataset $dataset, ViewEnum $view, Request $request): ?Chart
    {
        $query = $this->queryBuilder->process($view, $dataset, $request);

        try {
            $result = $this
                ->getConnection()
                ->executeQuery(
                    $query->getStatement(),
                    $query->getBindValues(),
                )
                ->fetchAllAssociative();

            return $this->chartDataTransformer->toDomain($result, $view, $query, $request);
        } catch (\Exception $e) {
            $this->loggerInterface->error(
                $e->getMessage(),
                [
                    'statement' => $query->getStatement(),
                    'bindValues' => $query->getBindValues(),
                    'view' => $view->value,
                ],
            );

            return null;
        }
    }
}
