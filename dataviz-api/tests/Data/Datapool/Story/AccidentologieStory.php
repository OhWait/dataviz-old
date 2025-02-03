<?php

declare(strict_types=1);

namespace App\Tests\Data\Datapool\Story;

use App\Domain\Dataviz\Enum\Dataset\DataProviderEnum;
use App\Domain\Dataviz\Enum\MetaColumn\DataTypeEnum;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySchemaName;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntrySlug;
use App\Domain\Dataviz\ValueObject\DataEntry\DataEntryTableName;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnColumnName;
use App\Domain\Dataviz\ValueObject\MetaColumn\MetaColumnDataType;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowLabel;
use App\Domain\Dataviz\ValueObject\MetaRow\MetaRowValue;
use App\Tests\Data\Dataviz\Factory\DataEntryFactory;
use App\Tests\Data\Dataviz\Factory\DatasetFactory;
use App\Tests\Data\Dataviz\Factory\MetaColumnFactory;
use App\Tests\Data\Dataviz\Factory\MetaRowFactory;

class AccidentologieStory extends BaseStory
{
    public static function accident()
    {
        self::insertData('Accidentologie.sql');

        $dataset = DatasetFactory::createOne([
            'slug' => new DatasetSlug('accidents-corporels'),
            'dataProvider' => new DatasetDataProvider(DataProviderEnum::ACCIDENTOLOGY->value),
        ]);

        $caractEntry = DataEntryFactory::createOne([
            'slug' => new DataEntrySlug('acc-caracteristique'),
            'schemaName' => new DataEntrySchemaName('etat'),
            'tableName' => new DataEntryTableName('acc_caracteristique'),
            'dataset' => $dataset,
        ]);

        MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('num_acc'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::CHARACTER_VARYING->value),
            'dataEntry' => $caractEntry,
        ]);
        MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('date'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::TIMESTAMP_WTZ->value),
            'dataEntry' => $caractEntry,
        ]);

        $usagerEntry = DataEntryFactory::createOne([
            'slug' => new DataEntrySlug('acc-usager'),
            'schemaName' => new DataEntrySchemaName('etat'),
            'tableName' => new DataEntryTableName('acc_usager'),
            'dataset' => $dataset,
        ]);

        MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('num_acc'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::CHARACTER_VARYING->value),
            'dataEntry' => $usagerEntry,
        ]);
        $grav = MetaColumnFactory::createOne([
            'columnName' => new MetaColumnColumnName('grav'),
            'dataType' => new MetaColumnDataType(DataTypeEnum::CHARACTER_VARYING->value),
            'dataEntry' => $usagerEntry,
        ]);

        MetaRowFactory::createOne([
            'label' => new MetaRowLabel('Indemne'),
            'value' => new MetaRowValue('1'),
            'metaColumn' => $grav,
        ]);
        MetaRowFactory::createOne([
            'label' => new MetaRowLabel('Tué'),
            'value' => new MetaRowValue('2'),
            'metaColumn' => $grav,
        ]);
        MetaRowFactory::createOne([
            'label' => new MetaRowLabel('Blesser hospitalisé'),
            'value' => new MetaRowValue('3'),
            'metaColumn' => $grav,
        ]);
        MetaRowFactory::createOne([
            'label' => new MetaRowLabel('Blesser léger'),
            'value' => new MetaRowValue('4'),
            'metaColumn' => $grav,
        ]);
    }
}
