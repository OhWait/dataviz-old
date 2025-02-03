<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Operation;

use App\Shared\Infrastructure\Operation\SingularPathSegmentNameGenerator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SingularPathSegmentNameGeneratorTest extends TestCase
{
    private SingularPathSegmentNameGenerator $generator;

    public function setUp(): void
    {
        $this->generator = new SingularPathSegmentNameGenerator();
    }

    #[DataProvider('getSegmentsNames')]
    public function testGivenPlurialUriTemplateReturnSingularSegmentName(
        string $name,
        string $expected,
    ): void {
        $actual = $this->generator->getSegmentName($name);

        $this->assertEquals($expected, $actual);
    }

    public static function getSegmentsNames(): iterable
    {
        yield ['/api/charts', '/api/charts'];
        yield ['/apis/providers', '/apis/providers'];
        yield ['/apis/provider', '/apis/provider'];
        yield ['/API/gazs', '/a-p-i/gazs'];
        yield ['/api/PLURIALS', '/api/p-l-u-r-i-a-l-s'];
        yield ['/api/PascalCase', '/api/pascal-case'];
    }
}
