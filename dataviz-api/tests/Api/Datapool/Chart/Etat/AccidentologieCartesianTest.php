<?php

declare(strict_types=1);

namespace App\Tests\Api\Datapool\Chart\Etat;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Domain\Datapool\Enum\Chart\OperationTypeEnum;
use App\Tests\Data\Datapool\Story\AccidentologieStory;
use Aura\SqlQuery\QueryFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class AccidentologieCartesianTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function setUp(): void
    {
        AccidentologieStory::accident();
    }

    public function testPostInvalidColumns(): void
    {
        static::createClient()->request('POST', '/chart/accidents-corporels/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'date',
                ],
                'operation' => [
                    'column' => 'num_acc',
                    'operation' => 'COUNT',
                ],
                'serie' => [
                    'column' => 'grav',
                    'dataEntry' => 'acc-caracteristique',
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
                    'propertyPath' => 'axisDistribution.dataEntry',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ acc-caracteristique, acc-usager ]',
                    'code' => 'ERROR',
                ], [
                    'propertyPath' => 'axisOperation.dataEntry',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ acc-caracteristique, acc-usager ]',
                    'code' => 'ERROR',
                ], [
                    'propertyPath' => 'serie.column',
                    'message' => 'The column you selected is not a valid choice. Allowed columns are [ num_acc, date ]',
                    'code' => 'ERROR',
                ],
            ],
        ]);
    }

    public function testPostSingleTableRequestDoesNotLeftJoin(): void
    {
        static::createClient()->request('POST', '/chart/accidents-corporels/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'date',
                    'dataEntry' => 'acc-caracteristique',
                ],
                'operation' => [
                    'column' => 'num_acc',
                    'operation' => 'SUM',
                    'dataEntry' => 'acc-caracteristique',
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $sqlExpected = (new QueryFactory('pgsql'))
            ->newSelect()
            ->cols(['acc_caracteristique.date' => 'x', 'COUNT(acc_caracteristique.num_acc)' => 'y'])
            ->from('etat.acc_caracteristique AS acc_caracteristique')
            ->groupBy(['"x"'])
            ->orderBy(['"x"']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'series' => [[
                'data' => [],
            ]],
            'query' => [
                'statement' => $sqlExpected->getStatement(),
                'bindValues' => $sqlExpected->getBindValues(),
            ],
        ]);
    }

    public function testPostWithDateAggregationReturnXaxisByMonth(): void
    {
        static::createClient()->request('POST', '/chart/accidents-corporels/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'date',
                    'dateOperation' => OperationTypeEnum::MONTHLY->value,
                    'dataEntry' => 'acc-caracteristique',
                ],
                'operation' => [
                    'column' => 'num_acc',
                    'operation' => 'SUM',
                    'dataEntry' => 'acc-caracteristique',
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $sqlExpected = (new QueryFactory('pgsql'))
            ->newSelect()
            ->cols(['to_char(acc_caracteristique.date, \'YYYY-MM\')' => 'x', 'COUNT(acc_caracteristique.num_acc)' => 'y'])
            ->from('etat.acc_caracteristique AS acc_caracteristique')
            ->groupBy(['"x"'])
            ->orderBy(['"x"']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'series' => [[
                'data' => [
                    ['x' => '2021-01', 'y' => 12.0, 'label' => '2021-01'],
                    ['x' => '2021-02', 'y' => 11.0, 'label' => '2021-02'],
                    ['x' => '2021-03', 'y' => 21.0, 'label' => '2021-03'],
                    ['x' => '2021-04', 'y' => 16.0, 'label' => '2021-04'],
                    ['x' => '2021-05', 'y' => 16.0, 'label' => '2021-05'],
                    ['x' => '2021-06', 'y' => 15.0, 'label' => '2021-06'],
                    ['x' => '2021-07', 'y' => 26.0, 'label' => '2021-07'],
                    ['x' => '2021-08', 'y' => 18.0, 'label' => '2021-08'],
                    ['x' => '2021-09', 'y' => 24.0, 'label' => '2021-09'],
                    ['x' => '2021-10', 'y' => 17.0, 'label' => '2021-10'],
                    ['x' => '2021-11', 'y' => 13.0, 'label' => '2021-11'],
                    ['x' => '2021-12', 'y' => 9.0, 'label' => '2021-12'],
                ],
            ]],
            'query' => [
                'statement' => $sqlExpected->getStatement(),
                'bindValues' => $sqlExpected->getBindValues(),
            ],
        ]);
    }

    public function testPostWithDateAggregationReturnXaxisByYearAndSerie(): void
    {
        static::createClient()->request('POST', '/chart/accidents-corporels/cartesian', [
            'json' => [
                'distribution' => [
                    'column' => 'date',
                    'dateOperation' => OperationTypeEnum::YEARLY->value,
                    'dataEntry' => 'acc-caracteristique',
                ],
                'operation' => [
                    'column' => 'num_acc',
                    'operation' => 'SUM',
                    'dataEntry' => 'acc-caracteristique',
                ],
                'serie' => [
                    'column' => 'grav',
                    'dataEntry' => 'acc-usager',
                ],
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $sqlExpected = (new QueryFactory('pgsql'))
            ->newSelect()
            ->cols([
                'to_char(acc_caracteristique.date, \'YYYY\')' => 'x',
                'COUNT(acc_caracteristique.num_acc)' => 'y',
                'acc_usager.grav' => 'serie',
            ])
            ->from('etat.acc_caracteristique AS acc_caracteristique')
            ->leftJoin('etat.acc_usager AS acc_usager', '"acc_caracteristique"."num_acc" = "acc_usager"."num_acc"')
            ->groupBy(['"x"', '"serie"'])
            ->orderBy(['"x"', '"serie"']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'series' => [[
                'label' => 'Indemne',
                'data' => [
                    ['x' => '2021', 'y' => 2.0, 'label' => '2021'],
                ],
            ], [
                'label' => 'Tué',
                'data' => [
                    ['x' => '2021', 'y' => 1.0, 'label' => '2021'],
                ],
            ], [
                'label' => 'Blesser hospitalisé',
                'data' => [
                    ['x' => '2021', 'y' => 3.0, 'label' => '2021'],
                ],
            ], [
                'label' => 'Blesser léger',
                'data' => [
                    ['x' => '2021', 'y' => 1.0, 'label' => '2021'],
                ],
            ], [
                'data' => [
                    ['x' => '2021', 'y' => 194.0, 'label' => '2021'],
                ],
            ]],
            'query' => [
                'statement' => $sqlExpected->getStatement(),
                'bindValues' => $sqlExpected->getBindValues(),
            ],
        ]);
    }
}
