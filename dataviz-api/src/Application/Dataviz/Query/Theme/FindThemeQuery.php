<?php

declare(strict_types=1);

namespace App\Application\Dataviz\Query\Theme;

use App\Domain\Dataviz\ValueObject\Theme\ThemeSlug;

final readonly class FindThemeQuery
{
    public function __construct(
        public ThemeSlug $slug,
    ) {
    }
}
