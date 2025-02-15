<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Dataset;
use App\Entity\Provider;
use App\Tests\Data\Factory\DatasetFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class DatasetCrudTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public const URL = '/dataset';

    public function testGetCollection(): void
    {
        DatasetFactory::createMany(100);

        $response = static::createClient()->request(Request::METHOD_GET, self::URL);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Dataset::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Dataset',
            '@id' => self::URL,
            '@type' => 'Collection',
            'totalItems' => 100,
        ]);
        $this->assertCount(50, $response->toArray()['member']);
    }

    public function testGetItem(): void
    {
        DatasetFactory::createOne(['slug' => 'my-slug']);

        $iri = $this->findIriBy(Dataset::class, ['slug' => 'my-slug']);

        static::createClient()->request(Request::METHOD_GET, $iri);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(Dataset::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Dataset',
            '@id' => $iri,
            '@type' => 'Dataset',
        ]);
    }

    public function testPostItem(): void
    {
        $data = DatasetFactory::createOne();

        $providerIri = $this->findIriBy(Provider::class, ['slug' => $data->getProvider()->getSlug()]);

        $response = static::createClient()->request(
            Request::METHOD_POST, 
            self::URL,
            [
                'json' => [
                    'slug' => 'random-slug',
                    'title' => $data->getTitle(),
                    'description' => $data->getDescription(),
                    'perimeter' => $data->getPerimeter(),
                    'granularity' => $data->getGranularity(),
                    'updateFrequency' => $data->getUpdateFrequency(),
                    'updatePeriod' => $data->getUpdatePeriod(),
                    'security' => $data->getSecurity(),
                    'language' => $data->getLanguage(),
                    'dataCreatedAt' => $data->getDataCreatedAt()?->format('Y-m-d'),
                    'dataUpdatedAt' => $data->getDataUpdatedAt()?->format('Y-m-d'),
                    'dataProvider' => $data->getDataProvider(),
                    'provider' => $providerIri,
                ]
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(array_filter([
            '@context' => '/contexts/Dataset',
            '@type' => 'Dataset',
            'slug' => 'random-slug',
            'title' => $data->getTitle(),
            'description' => $data->getDescription(),
            'perimeter' => $data->getPerimeter(),
            'granularity' => $data->getGranularity(),
            'updateFrequency' => $data->getUpdateFrequency(),
            'updatePeriod' => $data->getUpdatePeriod(),
            'security' => $data->getSecurity(),
            'language' => $data->getLanguage(),
            'dataCreatedAt' => $data->getDataCreatedAt()?->format('Y-m-d'),
            'dataUpdatedAt' => $data->getDataUpdatedAt()?->format('Y-m-d'),
            'dataProvider' => $data->getDataProvider(),
            'createdAt' => $response->toArray()['createdAt'],
            'updatedAt' => $response->toArray()['updatedAt'],
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
                    'propertyPath' => 'title',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'perimeter',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'granularity',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'security',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'provider',
                    'message' => 'This value should not be null.',
                ]
            ],
        ]);
    }

    public function testUpdateItem(): void
    {
        DatasetFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();

        $iri = $this->findIriBy(Dataset::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_PATCH, $iri, [
            'json' => ['description' => 'updated description'],
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'slug' => 'my-slug',
            'description' => 'updated description',
        ]);
    }

    public function testUpdateItemUnprocessable(): void
    {
        DatasetFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();

        $iri = $this->findIriBy(Dataset::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_PATCH, $iri, [
            'json' => [
                'description' => 'updated description',
                'granularity' => 'invalid granularity',
            ],
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonContains([
            'violations' => [
                [
                    'propertyPath' => 'granularity',
                    'message' => 'The value you selected is not a valid choice.',
                ],
            ],
        ]);
    }

    public function testDeleteItem(): void
    {
        DatasetFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();
        $iri = $this->findIriBy(Dataset::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_DELETE, $iri);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        $this->assertNull(
            static::getContainer()
                ->get('doctrine')
                ->getRepository(Dataset::class)
                ->findOneBy(['slug' => 'my-slug'])
        );
    }
}
