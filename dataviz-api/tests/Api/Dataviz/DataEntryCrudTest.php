<?php

declare(strict_types=1);

namespace App\Tests\Api\Dataviz;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Dataviz\Repository\DataEntryRepositoryInterface;
use App\Presentation\Dataviz\Resource\DataEntryResource;
use App\Tests\Data\Datapool\Story\InseePopStory;
use App\Tests\Data\Dataviz\Factory\DataEntryFactory;
use App\Tests\Data\Dataviz\Factory\MetaColumnFactory;
use App\Tests\Data\Dataviz\Factory\MetaRowFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class DataEntryCrudTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    // GET
    public function testGetCollection(): void
    {
        DataEntryFactory::createMany(100);

        $response = static::createClient()->request(Request::METHOD_GET, '/data-entry');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(DataEntryResource::class);
        $this->assertJsonContains([
            '@context' => '/contexts/DataEntry',
            '@id' => '/data-entry',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
        ]);
        $this->assertCount(50, $response->toArray()['hydra:member']);
    }

    public function testGetItem(): void
    {
        $data = DataEntryFactory::createOne();
        $columns = MetaColumnFactory::createMany(100, ['dataEntry' => $data]);
        MetaRowFactory::createMany(10, ['metaColumn' => $columns[0]]);

        static::createClient()->request(Request::METHOD_GET, "/data-entry/{$data->slug()->value}");

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(DataEntryResource::class);
        $this->assertJsonContains([
            '@context' => '/contexts/DataEntry',
            '@id' => "/data-entry/{$data->slug()}",
            '@type' => 'DataEntry',
        ]);
    }

    public function testTablePreview(): void
    {
        $dataset = InseePopStory::pop1a();

        $dataEntry = static::getContainer()->get(DataEntryRepositoryInterface::class)->find($dataset->slug());

        static::createClient()->request(Request::METHOD_GET, "/data-entry/{$dataEntry->slug()}/table");

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/DataEntry',
            '@id' => "/data-entry/{$dataEntry->slug()}/table",
            '@type' => 'hydra:Collection',
        ]);
    }

    // POST
    public function testPostItem(): void
    {
        DataEntryFactory::createMany(100);

        static::createClient()->request(Request::METHOD_POST, '/dataset');

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testPatchItem(): void
    {
        $data = DataEntryFactory::createOne();

        static::createClient()->request(Request::METHOD_PATCH, "/dataset/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testDeleteItem(): void
    {
        $data = DataEntryFactory::createOne();

        static::createClient()->request(Request::METHOD_DELETE, "/dataset/{$data->slug()}");

        $this->assertResponseStatusCodeSame(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
