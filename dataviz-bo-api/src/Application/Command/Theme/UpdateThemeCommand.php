<?php

declare(strict_types=1);

namespace App\Application\Command\Theme;

use App\Domain\ValueObject\Theme\ThemeSlug;
use App\Domain\ValueObject\Theme\ThemeTitle;

final readonly class UpdateThemeCommand
{
    public function __construct(
        public ThemeSlug $slug,
        public ThemeTitle $title,
    ) {
    }
}
