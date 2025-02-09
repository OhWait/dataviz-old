<?php

declare(strict_types=1);

namespace App\Tests\Api\Dataviz;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Presentation\Dataviz\Resource\DatasetResource;
use App\Tests\Data\Dataviz\Factory\DatasetFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $this->assertMatchesResourceCollectionJsonSchema(DatasetResource::class);
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

        static::createClient()->request(Request::METHOD_GET, "/dataset/{$dataset->slug()->value}");

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(DatasetResource::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Dataset',
            '@id' => "/dataset/{$dataset->slug()}",
            '@type' => 'Dataset',
        ]);
    }

    public function testPostItem(): void
    {
        static::createClient()->request(Request::METHOD_POST, '/dataset');

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testPatchItem(): void
    {
        $data = DatasetFactory::createOne();

        static::createClient()->request(Request::METHOD_PATCH, "/dataset/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testDeleteItem(): void
    {
        $data = DatasetFactory::createOne();

        static::createClient()->request(Request::METHOD_DELETE, "/dataset/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
