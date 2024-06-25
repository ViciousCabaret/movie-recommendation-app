<?php

namespace App\Tests\Unit\SearchEngine\Filter;

use App\DataProvider\Interface\DataProviderInterface;
use App\Service\SearchEngine\Filter\RandomizationFilter;
use App\Service\SearchEngine\SearchEngine;
use App\Tests\Unit\Utils\FilterableProviderUtil;
use PHPUnit\Framework\TestCase;

class RandomizationFilterTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testRandomFilter(
        array $data,
        int $requestedAmount,
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

        $result = $searchEngine->search([new RandomizationFilter($requestedAmount)]);

        $this->assertCount($expectedCount, $result);
    }

    public function dataProvider(): array
    {
        return [
            'no recommendable provided, requested 3, expects 0' => [
                [],
                3,
                0,
            ],
            'two recommendable provided, requested 3, expects 2' => [
               ['test1', 'test2'],
               3,
               2,
            ],
            '5 recommendable provided, requested 4, expects 4' => [
                ['test1', 'test2', 'test3', 'test4'],
                4,
                4,
            ],
        ];
    }
}