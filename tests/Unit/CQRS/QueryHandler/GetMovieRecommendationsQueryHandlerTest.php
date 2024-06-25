<?php

namespace App\Tests\Unit\CQRS\QueryHandler;

use App\CQRS\Query\GetMovieRecommendationsQuery;
use App\CQRS\QueryHandler\GetMovieRecommendationsQueryHandler;
use App\DataProvider\MoviesProvider;
use App\Enum\RecommendationAlgorithmEnum;
use App\Tests\Unit\Utils\MovieDTOProviderUtil;
use PHPUnit\Framework\TestCase;

class GetMovieRecommendationsQueryHandlerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGetMovieRecommendationQueryHandler(
        array $moviesList,
        RecommendationAlgorithmEnum $recommendationAlgorithmEnum,
        int $expectedCount,
    ): void
    {
        $query = new GetMovieRecommendationsQuery(
            $recommendationAlgorithmEnum,
        );

        $movieProviderMock = $this->getMockBuilder(MoviesProvider::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getAll'])
            ->getMock();

        $movieProviderMock->expects($this->any())
            ->method('getAll')
            ->willReturn(MovieDTOProviderUtil::createMovieDTOFromTitleList($moviesList));

        $handler = new GetMovieRecommendationsQueryHandler($movieProviderMock);
        $result = $handler($query);

        $this->assertCount($expectedCount, $result);
    }

    public function dataProvider(): array
    {
        return [
            'no movies provided, three random movies recommendation, expects 0' => [
                [],
                RecommendationAlgorithmEnum::THREE_RANDOM_MOVIES_RECOMMENDATION,
                0,
            ],
            'static movies list provided, three random movies recommendation, expects 3' => [
                $this->getStaticMoviesList(),
                RecommendationAlgorithmEnum::THREE_RANDOM_MOVIES_RECOMMENDATION,
                3,
            ],
            'no movies provided, multi-world title recommendation, expects 0' => [
                [],
                RecommendationAlgorithmEnum::MULTI_WORD_RECOMMENDATION,
                0,
            ],
            'static movies list provided, multi-world title recommendation, expects 5' => [
                $this->getStaticMoviesList(),
                RecommendationAlgorithmEnum::MULTI_WORD_RECOMMENDATION,
                5,
            ],
            'no movies provided, even letters starts with w recommendation, expects 0' => [
                [],
                RecommendationAlgorithmEnum::EVEN_LETTERS_WITH_LETTER_W_IN_TITLE_RECOMMENDATION,
                0,
            ],
            'static movies list provided, even letters starts with w recommendation, expects 2' => [
                $this->getStaticMoviesList(),
                RecommendationAlgorithmEnum::EVEN_LETTERS_WITH_LETTER_W_IN_TITLE_RECOMMENDATION,
                2,
            ],
        ];
    }

    public function getStaticMoviesList(): array
    {
        return [
            'test1',
            'test2',
            'test ',
            'test 2',
            'test 3',
            'Wtest 21',
            'wtest 22',
            'Wtest 2',
        ];
    }
}