<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Dataset;
use App\Entity\Provider;
use App\Tests\Data\Factory\DatasetFactory;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class DatasetCrudTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    // GET
    public function testGetCollection(): void
    {
        DatasetFactory::createMany(100);

        $response = static::createClient()->request(Request::METHOD_GET, '/dataset');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Dataset::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Dataset',
            '@id' => '/dataset',
            '@type' => 'Collection',
            'totalItems' => 100,
        ]);
        $this->assertCount(50, $response->toArray()['member']);
    }

    public function testGetItem(): void
    {
        $dataset = DatasetFactory::createOne();

        static::createClient()->request(Request::METHOD_GET, "/dataset/{$dataset->getSlug()}");

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(Dataset::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Dataset',
            '@id' => "/dataset/{$dataset->getSlug()}",
            '@type' => 'Dataset',
        ]);
    }

    public function testPostItem(): void
    {
        $data = DatasetFactory::createOne();

        $response = static::createClient()->request(
            Request::METHOD_POST, 
            '/dataset',
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
                    'provider' => "/provider/{$data->getProvider()->getSlug()}",
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
}
