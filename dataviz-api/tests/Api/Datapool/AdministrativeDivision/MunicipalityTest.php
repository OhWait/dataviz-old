<?php

declare(strict_types=1);

namespace App\Tests\Api\Datapool\AdministrativeDivision;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Data\Datapool\Factory\MunicipalityFactory;
use App\Tests\Data\Datapool\Story\BaseStory;
use Symfony\Component\HttpFoundation\Request;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class MunicipalityTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function setUp(): void
    {
        BaseStory::insertData('Territoire.sql');
    }

    // GET
    public function testGetCollection(): void
    {
        MunicipalityFactory::createMany(100);

        $response = static::createClient()->request(Request::METHOD_GET, '/administrative-division/municipality');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/AdministrativeDivision',
            '@id' => '/administrative-division/municipality',
            '@type' => 'Collection',
            'totalItems' => 100,
        ]);
        $this->assertCount(50, $response->toArray()['member']);
    }
}
