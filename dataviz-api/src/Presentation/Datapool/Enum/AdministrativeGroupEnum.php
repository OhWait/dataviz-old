<?php

declare(strict_types=1);

namespace App\Presentation\Datapool\Enum;

enum AdministrativeGroupEnum: string
{
    public const MUNICIPALITY = 'administrative:municipality';
    public const PIIC = 'administrative:piic';
    public const DEPARTMENT = 'administrative:department';
}
