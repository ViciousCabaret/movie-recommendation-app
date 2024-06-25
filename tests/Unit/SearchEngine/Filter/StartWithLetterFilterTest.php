<?php

namespace App\Tests\Unit\SearchEngine\Filter;

use App\DataProvider\Interface\DataProviderInterface;
use App\Service\SearchEngine\Filter\StartsWithLetterFilter;
use App\Service\SearchEngine\SearchEngine;
use App\Tests\Unit\Utils\FilterableProviderUtil;
use PHPUnit\Framework\TestCase;

class StartWithLetterFilterTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testStartWithLetterFilter(
        array $data,
        string $letter,
        int $expectedCount,
    ): void {
        $recommendableProviderMock = $this->getMockBuilder(DataProviderInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getAll'])
            ->getMock();

        $recommendableProviderMock->expects($this->any())
            ->method('getAll')
            ->willReturn(FilterableProviderUtil::createFilterableObjectsFromString($data));

        $searchEngine = new SearchEngine(
            $recommendableProviderMock,
        );

        $result = $searchEngine->search([new StartsWithLetterFilter($letter)]);

        $this->assertCount($expectedCount, $result);
    }

    public function dataProvider(): array
    {
        return [
            'no recommendable provided, requested letter w, expects 0' => [
                [],
                'w',
                0,
            ],
            '2 t letters recommendable provided, requested letter w, expects 0' => [
                ['test1', 'test2'],
                'w',
                0,
            ],
            '2 w letters recommendable provided, requested letter w, expects 2' => [
                ['www', 'wwww'],
                'w',
                2,
            ],
            '2 w and r letters recommendable provided, requested letter r, expects 2' => [
                ['www', 'wwww', 'rrr', 'rrrr'],
                'r',
                2,
            ]
        ];
    }
}