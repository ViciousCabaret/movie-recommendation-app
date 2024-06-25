<?php

namespace App\Service\SearchEngine\Recommendation;

use App\Enum\RecommendationAlgorithmEnum;
use App\Service\SearchEngine\Filter\EvenLettersAmountFilter;
use App\Service\SearchEngine\Filter\StartsWithLetterFilter;
use App\Service\SearchEngine\Recommendation\Interface\RecommendationInterface;

class EvenLettersInTitleAndStartsWithLetterWRecommendation implements RecommendationInterface
{
    public function getSearchFilters(): array
    {
        return [
            new EvenLettersAmountFilter(),
            new StartsWithLetterFilter('w'),
        ];
    }

    public function getName(): RecommendationAlgorithmEnum
    {
        return RecommendationAlgorithmEnum::EVEN_LETTERS_WITH_LETTER_W_IN_TITLE_RECOMMENDATION;
    }
}
