<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Provider;

use App\Domain\Dataviz\Model\Provider;
use App\Domain\Dataviz\Repository\ProviderRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindProviderQueryHandler
{
    public function __construct(
        private ProviderRepositoryInterface $providerRepository,
    ) {
    }

    public function __invoke(FindProviderQuery $query): ?Provider
    {
        return $this->providerRepository->find($query->slug->value);
    }
}
