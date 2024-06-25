<?php

namespace App\Service\SearchEngine\Recommendation;

use App\Enum\RecommendationAlgorithmEnum;
use App\Service\SearchEngine\Filter\RandomizationFilter;
use App\Service\SearchEngine\Recommendation\Interface\RecommendationInterface;

class ThreeRandomMoviesRecommendation implements RecommendationInterface
{
    public function getSearchFilters(): array
    {
        return [
            new RandomizationFilter(3),
        ];
    }

    public function getName(): RecommendationAlgorithmEnum
    {
        return RecommendationAlgorithmEnum::THREE_RANDOM_MOVIES_RECOMMENDATION;
    }
}
