<?php

declare(strict_types=1);

namespace App\Application\Query\Theme;

use App\Domain\Model\Theme;
use App\Domain\Repository\ThemeRepositoryInterface;
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
