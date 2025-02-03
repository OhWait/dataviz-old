<?php

declare(strict_types=1);

namespace App\Application\Command\Theme;

use App\Domain\Model\Theme;
use App\Domain\Repository\ThemeRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
final readonly class UpdateThemeCommandHandler
{
    public function __construct(
        private readonly ThemeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(UpdateThemeCommand $command): Theme
    {
        $theme = $this->repository->find($command->slug->value);

        $theme->update(
            title: $command->title,
        );

        $this->repository->save($theme);

        return $theme;
    }
}
