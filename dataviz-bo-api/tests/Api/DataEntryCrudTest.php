<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\DataEntry;
use App\Entity\Dataset;
use App\Tests\Data\Dataviz\Factory\DatasetFactory;
use App\Tests\Data\Factory\MetaColumnFactory;
use App\Tests\Data\Factory\MetaRowFactory;
use App\Tests\Data\Factory\DataEntryFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class DataEntryCrudTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public const URL = '/data-entry';

    public function testGetCollection(): void
    {
        DataEntryFactory::createMany(100);

        $response = static::createClient()->request(Request::METHOD_GET, self::URL);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(DataEntry::class);
        $this->assertJsonContains([
            '@context' => '/contexts/DataEntry',
            '@id' => self::URL,
            '@type' => 'Collection',
            'totalItems' => 100,
        ]);
        $this->assertCount(50, $response->toArray()['member']);
    }

    public function testGetItem(): void
    {
        DataEntryFactory::createOne(['slug' => 'my-slug']);

        $iri = $this->findIriBy(DataEntry::class, ['slug' => 'my-slug']);

        static::createClient()->request(Request::METHOD_GET, $iri);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(DataEntry::class);
        $this->assertJsonContains([
            '@context' => '/contexts/DataEntry',
            '@id' => $iri,
            '@type' => 'DataEntry',
        ]);
    }

    public function testPostItem(): void
    {
        $metaRow = MetaRowFactory::createOne();
        $metaColumn = $metaRow->getMetaColumn();
        $data = $metaColumn->getDataEntry();

        $iri = $this->findIriBy(Dataset::class, ['slug' => $data->getDataset()->getSlug()]);

        $response = static::createClient()->request(
            Request::METHOD_POST, 
            self::URL,
            [
                'json' => [
                    'slug' => 'my-slug',
                    'title' => $data->getTitle(),
                    'schemaName' => $data->getSchemaName(),
                    'tableName' => 'my-slug',
                    'metaColumns' => [[
                        'columnName' => $metaColumn->getColumnName(),
                        'nullable' => $metaColumn->isNullable(),
                        'dataType' => $metaColumn->getDataType(),
                        'characterMaximumLength' => $metaColumn->getCharacterMaximumLength(),
                        'label' => $metaColumn->getLabel(),
                        'metaRows' => [[
                            'value' => $metaRow->getValue(),
                            'label' => $metaRow->getLabel(),
                        ]],
                    ]],
                    'dataset' => $iri,
                ]
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(array_filter([
            '@context' => '/contexts/DataEntry',
            '@type' => 'DataEntry',
            'slug' => 'my-slug',
            'title' => $data->getTitle(),
            'schemaName' => $data->getSchemaName(),
            'tableName' => 'my-slug',
            'metaColumns' => [array_filter([
                'columnName' => $metaColumn->getColumnName(),
                'nullable' => $metaColumn->isNullable(),
                'dataType' => $metaColumn->getDataType(),
                'characterMaximumLength' => $metaColumn->getCharacterMaximumLength(),
                'label' => $metaColumn->getLabel(),
                'metaRows' => [[
                    'value' => $metaRow->getValue(),
                    'label' => $metaRow->getLabel(),   
                ]],
            ])],
            'dataset' => array_filter([
                'title' => $data->getDataset()->getTitle(),
                'shortTitle' => $data->getDataset()->getShortTitle(),
            ])
        ]));
    }

    public function testPostInvalidItem(): void
    {
        static::createClient()->request(Request::METHOD_POST, self::URL, ['json' => []]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonContains([
            'violations' => [
                [
                    'propertyPath' => 'slug',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'slug',
                    'message' => 'This value should not be null.',
                ],
                [
                    'propertyPath' => 'title',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'title',
                    'message' => 'This value should not be null.',
                ],
                [
                    'propertyPath' => 'schemaName',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'schemaName',
                    'message' => 'This value should not be null.',
                ],
                [
                    'propertyPath' => 'tableName',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'tableName',
                    'message' => 'This value should not be null.',
                ],
                [
                    'propertyPath' => 'dataset',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'dataset',
                    'message' => 'This value should not be null.',
                ]
            ],
        ]);
    }

    public function testUpdateItem(): void
    {
        DataEntryFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();

        $iri = $this->findIriBy(DataEntry::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_PATCH, $iri, [
            'json' => ['title' => 'updated title'],
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'slug' => 'my-slug',
            'title' => 'updated title',
        ]);
    }

    public function testUpdateItemUnprocessable(): void
    {
        DataEntryFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();

        $iri = $this->findIriBy(DataEntry::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_PATCH, $iri, [
            'json' => [
                'title' => 'updated title',
                'metaColumns' => [[
                    'dataType' => 'invalid data type',
                ]],
            ],
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonContains([
            'violations' => [
                [
                    'propertyPath' => 'metaColumns[0].columnName',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'metaColumns[0].columnName',
                    'message' => 'This value should not be null.',
                ],
                [
                    'propertyPath' => 'metaColumns[0].nullable',
                    'message' => 'This value should not be null.',
                ],
                [
                    'propertyPath' => 'metaColumns[0].dataType',
                    'message' => 'The value you selected is not a valid choice.',
                ],
            ],
        ]);
    }

    public function testDeleteItem(): void
    {
        DataEntryFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();
        $iri = $this->findIriBy(DataEntry::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_DELETE, $iri);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        $this->assertNull(
            static::getContainer()
                ->get('doctrine')
                ->getRepository(DataEntry::class)
                ->findOneBy(['slug' => 'my-slug'])
        );
    }
}
