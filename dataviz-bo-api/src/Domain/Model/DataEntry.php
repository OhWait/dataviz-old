<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\DataEntry\DataEntryCreatedAt;
use App\Domain\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\ValueObject\DataEntry\DataEntryTitle;
use App\Domain\ValueObject\DataEntry\DataEntryUpdatedAt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'data_entry')]
#[ORM\UniqueConstraint(
    name: 'schema_table_unique_idx',
    columns: ['schema_name', 'table_name'],
)]
class DataEntry
{
    #[ORM\Embedded(columnPrefix: false)]
    private DataEntryCreatedAt $createdAt;

    #[ORM\Embedded(columnPrefix: false)]
    private DataEntryUpdatedAt $updatedAt;

    /** @var Collection<int, MetaColumn> */
    #[ORM\OneToMany(mappedBy: 'dataEntry', targetEntity: MetaColumn::class, orphanRemoval: true)]
    private Collection $metaColumns;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private DataEntrySlug $slug,

        #[ORM\Embedded(columnPrefix: false)]
        private DataEntryTitle $title,

        #[ORM\Embedded(columnPrefix: false)]
        private DataEntrySchemaName $schemaName,

        #[ORM\Embedded(columnPrefix: false)]
        private DataEntryTableName $tableName,

        #[ORM\ManyToOne(inversedBy: 'dataEntries')]
        #[ORM\JoinColumn(nullable: false, referencedColumnName: 'slug')]
        private Dataset $dataset,
    ) {
        $this->createdAt = new DataEntryCreatedAt();
        $this->updatedAt = new DataEntryUpdatedAt();
        $this->metaColumns = new ArrayCollection();
    }

    public function update(
        ?DataEntryTitle $title,
        ?DataEntrySchemaName $schemaName,
        ?DataEntryTableName $tableName,
    ): void {
        $this->title = $title ?? $this->title;
        $this->schemaName = $schemaName ?? $this->schemaName;
        $this->tableName = $tableName ?? $this->tableName;
        $this->updatedAt = new DataEntryUpdatedAt();
    }

    public function slug(): DataEntrySlug
    {
        return $this->slug;
    }

    public function title(): DataEntryTitle
    {
        return $this->title;
    }

    public function schemaName(): DataEntrySchemaName
    {
        return $this->schemaName;
    }

    public function tableName(): DataEntryTableName
    {
        return $this->tableName;
    }

    public function createdAt(): DataEntryCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): DataEntryUpdatedAt
    {
        return $this->updatedAt;
    }

    public function dataset(): Dataset
    {
        return $this->dataset;
    }

    /**
     * @return Collection<int, MetaColumn>
     */
    public function metaColumns(): Collection
    {
        return $this->metaColumns;
    }
}
