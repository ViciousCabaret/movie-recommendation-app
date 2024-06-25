<?php

namespace App\CQRS\QueryHandler;

use App\CQRS\Query\GetMovieRecommendationsQuery;
use App\DataProvider\MoviesProvider;
use App\Service\SearchEngine\Recommendation\Interface\RecommendationInterface;
use App\Service\SearchEngine\SearchEngine;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetMovieRecommendationsQueryHandler
{
    public function __construct(
        private MoviesProvider $moviesProvider,
    ) {
    }

    public function __invoke(GetMovieRecommendationsQuery $query): array
    {
        /** @var RecommendationInterface $recommendationAlgorithm */
        $recommendationAlgorithmClass = $query->getAlgorithmEnum()->getRecommendationAlgorithm();
        $recommendationAlgorithm = new $recommendationAlgorithmClass();

        $searchEngine = new SearchEngine($this->moviesProvider);

        return $searchEngine->search($recommendationAlgorithm->getSearchFilters());
    }
}
