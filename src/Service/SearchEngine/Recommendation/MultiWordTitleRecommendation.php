<?php

namespace App\Service\SearchEngine\Recommendation;

use App\Enum\RecommendationAlgorithmEnum;
use App\Enum\WordsAmountFilterModeEnum;
use App\Service\SearchEngine\Filter\WordsAmountFilter;
use App\Service\SearchEngine\Recommendation\Interface\RecommendationInterface;

class MultiWordTitleRecommendation implements RecommendationInterface
{
    public function getSearchFilters(): array
    {
        return [
            new WordsAmountFilter(
                WordsAmountFilterModeEnum::MORE_THAN,
                1
            ),
        ];
    }

    public function getName(): RecommendationAlgorithmEnum
    {
        return RecommendationAlgorithmEnum::MULTI_WORD_RECOMMENDATION;
    }
}
