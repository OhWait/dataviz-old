<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Theme;

use App\Domain\Dataviz\Model\Theme;
use App\Domain\Dataviz\Repository\ThemeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class FindThemeQueryHandler
{
    public function __construct(
        private ThemeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(FindThemeQuery $query): ?Theme
    {
        return $this->repository->find($query->slug->value);
    }
}
