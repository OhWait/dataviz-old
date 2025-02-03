<?php

declare(strict_types=1);

namespace App\Tests\Api\Datapool\Chart\Insee;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Data\Datapool\Story\InseePopStory;
use Aura\SqlQuery\QueryFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class InseePop1aPolarTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function setUp(): void
    {
        InseePopStory::pop1a();
    }

    public function testPostInvalidColumns(): void
    {
        static::createClient()->request('POST', '/chart/pop1a/polar', [
            'json' => [
                'values' => [
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
                    'propertyPath' => 'values.column',
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
        static::createClient()->request('POST', '/chart/pop1a/polar', [
            'json' => [
                'values' => [
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
            ->cols(['SUM(pop1a.nb)' => 'y', 'pop1a.sexe' => 'serie'])
            ->from('insee.pop1a AS pop1a')
            ->where('pop1a.millesime IN (:millesime)', ['millesime' => ['2006', '2007']])
            ->groupBy(['"serie"'])
            ->orderBy(['"serie"']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'series' => [[
                'data' => [
                    ['y' => 2285.42213, 'label' => 'Hommes'],
                    ['y' => 2483.220985, 'label' => 'Femmes'],
                ],
            ]],
            'query' => [
                'statement' => $sqlExpected->getStatement(),
                'bindValues' => $sqlExpected->getBindValues(),
            ],
        ]);
    }
}
