<?php

declare(strict_types=1);

namespace App\Tests\Api\Dataviz;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Presentation\Dataviz\Resource\ThemeResource;
use App\Tests\Data\Dataviz\Factory\ThemeFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class ThemeCrudTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    // GET
    public function testGetCollection(): void
    {
        ThemeFactory::createMany(100);

        static::createClient()->request(Request::METHOD_GET, '/theme');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testGetItem(): void
    {
        $data = ThemeFactory::createOne();

        static::createClient()->request(Request::METHOD_GET, "/theme/{$data->slug()->value}");

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ThemeResource::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Theme',
            '@id' => "/theme/{$data->slug()}",
            '@type' => 'Theme',
        ]);
    }

    public function testPostItem(): void
    {
        static::createClient()->request(Request::METHOD_POST, '/theme');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testPatchItem(): void
    {
        $data = ThemeFactory::createOne();

        static::createClient()->request(Request::METHOD_PATCH, "/theme/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testPutItem(): void
    {
        $data = ThemeFactory::createOne();

        static::createClient()->request(Request::METHOD_PUT, "/theme/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testDeleteItem(): void
    {
        $data = ThemeFactory::createOne();

        static::createClient()->request(Request::METHOD_DELETE, "/theme/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
