<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Provider;
use App\Tests\Data\Factory\ProviderFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ProviderCrudTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    const URL = '/provider';

    public function testGetCollection(): void
    {
        ProviderFactory::createMany(100);

        $response = static::createClient()->request(Request::METHOD_GET, self::URL);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Provider::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Provider',
            '@id' => self::URL,
            '@type' => 'Collection',
            'totalItems' => 100,
        ]);
        $this->assertCount(50, $response->toArray()['member']);
    }

    public function testGetItem(): void
    {
        ProviderFactory::createOne(['slug' => 'my-slug']);

        $iri = $this->findIriBy(Provider::class, ['slug' => 'my-slug']);

        static::createClient()->request(Request::METHOD_GET, $iri);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(Provider::class);
        $this->assertJsonContains([
            '@context' => '/contexts/Provider',
            '@id' => $iri,
            '@type' => 'Provider',
        ]);
    }

    public function testPostItem(): void
    {
        $data = ProviderFactory::createOne();

        $response = static::createClient()->request(
            Request::METHOD_POST, 
            self::URL,
            [
                'json' => [
                    'slug' => 'random-slug',
                    'name' => $data->getName(),
                    'acronym' => $data->getAcronym(),
                    'description' => $data->getDescription(),
                ]
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(array_filter([
            '@context' => '/contexts/Provider',
            '@type' => 'Provider',
            'slug' => 'random-slug',
            'name' => $data->getName(),
            'acronym' => $data->getAcronym(),
            'description' => $data->getDescription(),
        ]));
    }

    public function testPostUploadLogo(): void
    {
        $slug = ProviderFactory::createOne()->getSlug();

        $sourcePath = __DIR__ . '/../Data/insee.png';
        $testPath = __DIR__ . '/../Data/insee_test.png';
        copy($sourcePath, $testPath);

        $file = new UploadedFile($testPath, 'insee.png', 'image/png', null, true);
        self::createClient()
            ->request(
                Request::METHOD_POST, 
                "/provider/{$slug}/upload-logo", 
                [
                    'headers' => ['Content-Type' => 'multipart/form-data'],
                    'extra' => [
                        'parameters' => [],
                        'files' => [
                            'file' => $file,
                        ],
                    ]
                ]
            );

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceItemJsonSchema(Provider::class);
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
                    'propertyPath' => 'name',
                    'message' => 'This value should not be blank.',
                ],
                [
                    'propertyPath' => 'name',
                    'message' => 'This value should not be null.',
                ],
            ],
        ]);
    }

    public function testUpdateItem(): void
    {
        ProviderFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();

        $iri = $this->findIriBy(Provider::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_PATCH, $iri, [
            'json' => ['name' => 'updated name'],
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'slug' => 'my-slug',
            'name' => 'updated name',
        ]);
    }

    public function testUpdateItemUnprocessable(): void
    {
        ProviderFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();

        $iri = $this->findIriBy(Provider::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_PATCH, $iri, [
            'json' => [
                'name' => '',
            ],
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonContains([
            'violations' => [
                [
                    'propertyPath' => 'name',
                    'message' => 'This value should not be blank.',
                ],
            ],
        ]);
    }

    public function testDeleteItem(): void
    {
        ProviderFactory::createOne(['slug' => 'my-slug']);

        $client = static::createClient();
        $iri = $this->findIriBy(Provider::class, ['slug' => 'my-slug']);

        $client->request(Request::METHOD_DELETE, $iri);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        $this->assertNull(
            static::getContainer()
                ->get('doctrine')
                ->getRepository(Provider::class)
                ->findOneBy(['slug' => 'my-slug'])
        );
    }
}