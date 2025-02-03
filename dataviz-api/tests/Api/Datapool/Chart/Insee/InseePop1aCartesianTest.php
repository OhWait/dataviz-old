<?php

declare(strict_types=1);

namespace App\Tests\Api\Datapool\Chart\Insee;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Data\Datapool\Story\InseePopStory;
use Aura\SqlQuery\QueryFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class InseePop1aCartesianTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function setUp(): void
    {
        InseePopStory::pop1a();
    }

    public function testPostInvalidColumns(): void
    {
        static::createClient()->request('POST', '/chart/pop1a/cartesian', [
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

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonContains([
            'title' => 'An error occurred',
            'violations' => [
                [
                    'propertyPath' => 'axisDistribution.column',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ millesime, nb, sexe ]',
                    'code' => 'ERROR',
                ], [
                    'propertyPath' => 'axisOperation.column',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ millesime, nb, sexe ]',
                    'code' => 'ERROR',
                ], [
                    'propertyPath' => 'serie.column',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ millesime, nb, sexe ]',
                    'code' => 'ERROR',
                ], [
                    'propertyPath' => 'filters[0].column',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ millesime, nb, sexe ]',
                    'code' => 'ERROR',
                ],
            ],
        ]);
    }

    public function testPostValidColumns(): void
    {
        static::createClient()->request('POST', '/chart/pop1a/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'millesime',
                ],
                'operation' => [
                    'column' => 'nb',
                    'operation' => 'SUM',
                ],
                'filters' => [[
                    'column' => 'millesime',
                    'values' => ['2006', '2007'],
                ], [
                    'column' => 'sexe',
                    'values' => ['1'],
                ]],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $sqlExpected = (new QueryFactory('pgsql'))
            ->newSelect()
            ->cols(['pop1a.millesime' => 'x', 'SUM(pop1a.nb)' => 'y'])
            ->from('insee.pop1a AS pop1a')
            ->where('pop1a.millesime IN (:millesime)', ['millesime' => ['2006', '2007']])
            ->where('pop1a.sexe = :sexe', ['sexe' => ['1']])
            ->groupBy(['"x"'])
            ->orderBy(['"x"']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'series' => [
                [
                    'data' => [
                        ['x' => '2006', 'y' => 1130.489759, 'label' => '2006'],
                        ['x' => '2007', 'y' => 1154.932371, 'label' => '2007'],
                    ],
                ],
            ],
            'query' => [
                'statement' => $sqlExpected->getStatement(),
                'bindValues' => $sqlExpected->getBindValues(),
            ],
        ]);
    }

    public function testPostValidColumnsWithSeries(): void
    {
        static::createClient()->request('POST', '/chart/pop1a/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'millesime',
                ],
                'operation' => [
                    'column' => 'nb',
                    'operation' => 'SUM',
                ],
                'serie' => ['column' => 'sexe'],
                'filters' => [[
                    'column' => 'millesime',
                    'values' => ['2006', '2007'],
                ]],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $sqlExpected = (new QueryFactory('pgsql'))
            ->newSelect()
            ->cols(['pop1a.millesime' => 'x', 'SUM(pop1a.nb)' => 'y', 'pop1a.sexe' => 'serie'])
            ->from('insee.pop1a AS pop1a')
            ->where('pop1a.millesime IN (:millesime)', ['millesime' => ['2006', '2007']])
            ->groupBy(['"x"', '"serie"'])
            ->orderBy(['"x"', '"serie"']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'series' => [
                [
                    'label' => 'Hommes',
                    'data' => [
                        ['x' => '2006', 'y' => 1130.489759, 'label' => '2006'],
                        ['x' => '2007', 'y' => 1154.932371, 'label' => '2007'],
                    ],
                ],
                [
                    'label' => 'Femmes',
                    'data' => [
                        ['x' => '2006', 'y' => 1246.69611, 'label' => '2006'],
                        ['x' => '2007', 'y' => 1236.524875, 'label' => '2007'],
                    ],
                ],
            ],
            'query' => [
                'statement' => $sqlExpected->getStatement(),
                'bindValues' => $sqlExpected->getBindValues(),
            ],
        ]);
    }
}
