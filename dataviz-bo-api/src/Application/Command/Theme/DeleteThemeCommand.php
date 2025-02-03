<?php

declare(strict_types=1);

namespace App\Application\Command\Theme;

use App\Domain\ValueObject\Theme\ThemeSlug;

final readonly class DeleteThemeCommand
{
    public function __construct(
        public ThemeSlug $slug,
    ) {
    }
}
