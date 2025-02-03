<?php

declare(strict_types=1);

namespace App\Application\Query\Theme;

use App\Domain\ValueObject\Theme\ThemeSlug;

final readonly class FindThemeQuery
{
    public function __construct(
        public ThemeSlug $slug,
    ) {
    }
}
