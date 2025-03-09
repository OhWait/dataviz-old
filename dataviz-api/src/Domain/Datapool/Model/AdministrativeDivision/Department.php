<?php

declare(strict_types=1);

namespace App\Domain\Datapool\Model\AdministrativeDivision;

use App\Domain\Datapool\ValueObject\Department\DepartmentCode;
use App\Domain\Datapool\ValueObject\Department\DepartmentLabel;
use App\Domain\Datapool\ValueObject\Department\DepartmentYear;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'territoire.departement')]
class Department
{
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private DepartmentYear $year,

        #[ORM\Embedded(columnPrefix: false)]
        private DepartmentCode $code,

        #[ORM\Column(length: 2, nullable: true)]
        public ?string $reg,

        #[ORM\Column(length: 5, nullable: true, name: 'cheflieu')]
        public ?string $capital,

        #[ORM\Column(length: 1, nullable: true)]
        public ?string $tncc,

        #[ORM\Column(length: 255)]
        public string $ncc,

        #[ORM\Column(length: 255)]
        public string $nccenr,

        #[ORM\Embedded(columnPrefix: false)]
        private DepartmentLabel $label,
    ) {
    }

    public function year(): DepartmentYear
    {
        return $this->year;
    }

    public function code(): DepartmentCode
    {
        return $this->code;
    }

    public function label(): DepartmentLabel
    {
        return $this->label;
    }
}
