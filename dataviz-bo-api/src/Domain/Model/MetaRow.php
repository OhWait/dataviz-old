<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\MetaRow\MetaRowId;
use App\Domain\ValueObject\MetaRow\MetaRowLabel;
use App\Domain\ValueObject\MetaRow\MetaRowValue;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('meta_row')]
class MetaRow
{
    #[ORM\Embedded(columnPrefix: false)]
    /** @phpstan-ignore-next-line */
    private MetaRowId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private MetaRowValue $value,

        #[ORM\Embedded(columnPrefix: false)]
        private MetaRowLabel $label,

        #[ORM\ManyToOne(targetEntity: MetaColumn::class, inversedBy: 'metaRows')]
        #[ORM\JoinColumn(nullable: false)]
        private ?MetaColumn $metaColumn = null,
    ) {
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
