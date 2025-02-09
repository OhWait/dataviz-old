<?php

declare(strict_types=1);

namespace App\Tests\Api\Dataviz;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Presentation\Dataviz\Resource\ProviderResource;
use App\Tests\Data\Dataviz\Factory\ProviderFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class ProviderCrudTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    // GET
    public function testGetCollection(): void
    {
        ProviderFactory::createMany(100);

        static::createClient()->request(Request::METHOD_GET, '/provider');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testGetItem(): void
    {
        $data = ProviderFactory::createOne();

        static::createClient()->request(Request::METHOD_GET, "/provider/{$data->slug()->value}");

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ProviderResource::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Provider',
            '@id' => "/provider/{$data->slug()}",
            '@type' => 'Provider',
        ]);
    }

    public function testPostItem(): void
    {
        static::createClient()->request(Request::METHOD_POST, '/provider');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testPatchItem(): void
    {
        $data = ProviderFactory::createOne();

        static::createClient()->request(Request::METHOD_PATCH, "/provider/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testPutItem(): void
    {
        $data = ProviderFactory::createOne();

        static::createClient()->request(Request::METHOD_PUT, "/provider/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testDeleteItem(): void
    {
        $data = ProviderFactory::createOne();

        static::createClient()->request(Request::METHOD_DELETE, "/provider/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
