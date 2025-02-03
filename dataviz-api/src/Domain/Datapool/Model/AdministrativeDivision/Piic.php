<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\AdministrativeDivision;

use App\Domain\Datapool\ValueObject\Piic\PiicCode;
use App\Domain\Datapool\ValueObject\Piic\PiicLabel;
use App\Domain\Datapool\ValueObject\Piic\PiicNature;
use App\Domain\Datapool\ValueObject\Piic\PiicYear;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'territoire.epci')]
class Piic
{
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private PiicYear $year,

        #[ORM\Embedded(columnPrefix: false)]
        private PiicCode $code,

        #[ORM\Embedded(columnPrefix: false)]
        private PiicLabel $label,

        #[ORM\Embedded(columnPrefix: false)]
        private PiicNature $nature,

        #[ORM\Column(length: 5, type: Types::INTEGER, name: 'nb_com')]
        public int $nbMunicipality,
    ) {
    }

    public function year(): PiicYear
    {
        return $this->year;
    }

    public function code(): PiicCode
    {
        return $this->code;
    }

    public function label(): PiicLabel
    {
        return $this->label;
    }

    public function nature(): PiicNature
    {
        return $this->nature;
    }
}
