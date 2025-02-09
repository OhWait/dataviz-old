<?php

declare(strict_types=1);

namespace App\Domain\Dataviz\Model;

use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowId;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowLabel;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowValue;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('meta_row')]
class MetaRow
{
    #[ORM\Embedded(columnPrefix: false)]
    public MetaRowId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private MetaRowValue $value,

        #[ORM\Embedded(columnPrefix: false)]
        private MetaRowLabel $label,

        #[ORM\ManyToOne(targetEntity: MetaColumn::class, inversedBy: 'metaRows')]
        #[ORM\JoinColumn(nullable: false)]
        private ?MetaColumn $metaColumn = null,
    ) {
        $this->id = new MetaRowId();
    }

    public function id(): MetaRowId
    {
        return $this->id;
    }

    public function value(): MetaRowValue
    {
        return $this->value;
    }

    public function label(): MetaRowLabel
    {
        return $this->label;
    }

    public function metaColumn(): MetaColumn
    {
        return $this->metaColumn;
    }
}
