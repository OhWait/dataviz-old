<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Story;

use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\Model\Dataset;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnLabel;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowLabel;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowValue;
use App\Tests\Data\Dataviz\Factory\DataEntryFactory;
use App\Tests\Data\Dataviz\Factory\DatasetFactory;
use App\Tests\Data\Dataviz\Factory\MetaColumnFactory;
use App\Tests\Data\Dataviz\Factory\MetaRowFactory;

class InseePopStory extends BaseStory
{
    public static function pop1a(): Dataset
    {
        self::insertData('InseePop1a.sql');

        $dataset = DatasetFactory::createOne([
            'slug' => new DatasetSlug('pop1a'),
            'dataProvider' => new DatasetDataProvider(DataProviderEnum::INSEE_TD->value),
        ]);

        $dataEntry = DataEntryFactory::createOne([
            'slug' => new DataEntrySlug('pop1a'),
            'schemaName' => new DataEntrySchemaName('insee'),
            'tableName' => new DataEntryTableName('pop1a'),
            'dataset' => $dataset,
        ]);

        MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('millesime'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::INTEGER->value),
            'dataEntry' => $dataEntry,
            'label' => new MetaColumnLabel('Millésime'),
        ]);

        MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('nb'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::INTEGER->value),
            'dataEntry' => $dataEntry,
            'label' => new MetaColumnLabel('Nombre'),
        ]);

        $sexe = MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('sexe'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::CHARACTER_VARYING->value),
            'dataEntry' => $dataEntry,
            'label' => new MetaColumnLabel('Sexe'),
        ]);

        MetaRowFactory::createOne([
            'label' => new MetaRowLabel('Hommes'),
            'value' => new MetaRowValue('1'),
            'metaColumn' => $sexe,
        ]);

        MetaRowFactory::createOne([
            'label' => new MetaRowLabel('Femmes'),
            'value' => new MetaRowValue('2'),
            'metaColumn' => $sexe,
        ]);

        return $dataset;
    }
}
