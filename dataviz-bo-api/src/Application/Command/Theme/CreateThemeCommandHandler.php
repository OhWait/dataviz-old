<?php

declare(strict_types=1);

namespace App\Application\Command\Theme;

use App\Domain\Model\Theme;
use App\Domain\Repository\ThemeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class CreateThemeCommandHandler
{
    public function __construct(
        private readonly ThemeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(CreateThemeCommand $command): Theme
    {
        $theme = new Theme(
            slug: $command->slug,
            title: $command->title,
        );

        $this->repository->save($theme);

        return $this->repository->find($command->slug);
    }
}
