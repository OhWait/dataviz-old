<?php

declare(strict_types=1);

namespace App\Tests\Api\Datapool\Chart;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetDataProvider;
use App\Domain\Dataviz\ValueObject\Dataset\DatasetSlug;
use App\Tests\Data\Dataviz\Factory\DatasetFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class ChartCartesianTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testPostUnknownDatasetReturnNotFoundResponse(): void
    {
        static::createClient()->request('POST', '/chart/unknown/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'FAKE_COLUMN',
                ],
                'operation' => [
                    'column' => 'FAKE_COLUMN',
                    'operation' => 'SUM',
                ],
                'serie' => [
                    'column' => 'FAKE_COLUMN',
                ],
                'filters' => [
                    [
                        'column' => 'FAKE_COLUMN',
                        'values' => ['2006', '2007'],
                    ], [
                        'column' => 'FAKE_COLUMN',
                        'values' => ['COM'],
                    ],
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testPostKnownDatasetWithoutDataProviderReturnNotFoundResponse(): void
    {
        DatasetFactory::createOne([
            'slug' => new DatasetSlug('known-one'),
            'dataProvider' => new DatasetDataProvider(null),
        ]);

        static::createClient()->request('POST', '/chart/known-one/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'FAKE_COLUMN',
                ],
                'operation' => [
                    'column' => 'FAKE_COLUMN',
                    'operation' => 'SUM',
                ],
                'serie' => [
                    'column' => 'FAKE_COLUMN',
                ],
                'filters' => [
                    [
                        'column' => 'FAKE_COLUMN',
                        'values' => ['2006', '2007'],
                    ], [
                        'column' => 'FAKE_COLUMN',
                        'values' => ['COM'],
                    ],
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
