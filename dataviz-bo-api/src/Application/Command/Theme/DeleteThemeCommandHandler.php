<?php

declare(strict_types=1);

namespace App\Application\Command\Theme;

use App\Domain\Repository\ThemeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class DeleteThemeCommandHandler
{
    public function __construct(private ThemeRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteThemeCommand $command): void
    {
        $provider = $this->repository->find($command->slug->value);

        $this->repository->remove($provider);
    }
}
