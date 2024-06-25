<?php

namespace App\Tests\Unit\SearchEngine\Filter;

use App\DataProvider\Interface\DataProviderInterface;
use App\Service\SearchEngine\Filter\EvenLettersAmountFilter;
use App\Service\SearchEngine\SearchEngine;
use App\Tests\Unit\Utils\FilterableProviderUtil;
use PHPUnit\Framework\TestCase;

class EvenLettersAmountFilterTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testEvenLettersAmountFilter(
        array $data,
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

        $result = $searchEngine->search([new EvenLettersAmountFilter()]);

        $this->assertCount($expectedCount, $result);
    }

    public function dataProvider(): array
    {
        return [
            'no recommendable provided, expects 0' => [
                [],
                0,
            ],
            '2 even letters recommendable provided, 1 even with space, 1 odd with space, expects 3' => [
                ['test', 'test12', 'test 12', 'test 123'],
                3,
            ],
        ];
    }
}