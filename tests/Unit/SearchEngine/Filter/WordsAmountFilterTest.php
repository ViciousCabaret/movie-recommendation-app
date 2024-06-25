<?php

namespace App\Tests\Unit\SearchEngine\Filter;

use App\DataProvider\Interface\DataProviderInterface;
use App\Enum\WordsAmountFilterModeEnum;
use App\Service\SearchEngine\Filter\WordsAmountFilter;
use App\Service\SearchEngine\SearchEngine;
use App\Tests\Unit\Utils\FilterableProviderUtil;
use PHPUnit\Framework\TestCase;

class WordsAmountFilterTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testWordsAmountFilter(
        array $data,
        WordsAmountFilterModeEnum $wordsAmountFilterModeEnum,
        int $wordsRequestedCount,
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

        $result = $searchEngine->search([new WordsAmountFilter($wordsAmountFilterModeEnum, $wordsRequestedCount)]);

        $this->assertCount($expectedCount, $result);
    }

    public function dataProvider(): array
    {
        return [
            'no recommendable provided, requested 1' => [
                [],
                WordsAmountFilterModeEnum::MORE_THAN,
                1,
                0,
            ],
            'one-word recommendable provided, more than 3 requested, expects 0' => [
                ['test'],
                WordsAmountFilterModeEnum::MORE_THAN,
                3,
                0,
            ],
            '2 two-word recommendable provided and 1 one-word recommendable provided, more than 1 requested, expects 2' => [
                ['test 1', 'test 2', 'test3'],
                WordsAmountFilterModeEnum::MORE_THAN,
                1,
                2,
            ],
            '2 three-word recommendable provided and 2 two-word recommendable provided, more than 2 requested, expects 2' => [
                ['test 1 2', 'test 2 2', 'test3', 'test4'],
                WordsAmountFilterModeEnum::MORE_THAN,
                2,
                2,
            ],
            '2 two-word recommendable provided and 2 three-word recommendable provided, exact 2 words requested, expects 2' => [
                ['test 1', 'test 2', 'test 1 1', 'test 2 2'],
                WordsAmountFilterModeEnum::EXACT,
                2,
                2,
            ]
        ];
    }
}