<?php

namespace App\Enum;

use App\Service\SearchEngine\Recommendation\EvenLettersInTitleAndStartsWithLetterWRecommendation;
use App\Service\SearchEngine\Recommendation\MultiWordTitleRecommendation;
use App\Service\SearchEngine\Recommendation\ThreeRandomMoviesRecommendation;

enum RecommendationAlgorithmEnum: string
{
    case THREE_RANDOM_MOVIES_RECOMMENDATION = 'three_random_movies_recommendation';
    case MULTI_WORD_RECOMMENDATION = 'multi_word_recommendation';
    case EVEN_LETTERS_WITH_LETTER_W_IN_TITLE_RECOMMENDATION = 'even_letters_with_letter_w_in_title_recommendation';

    public function getRecommendationAlgorithm(): string
    {
        return match ($this) {
            self::THREE_RANDOM_MOVIES_RECOMMENDATION => ThreeRandomMoviesRecommendation::class,
            self::MULTI_WORD_RECOMMENDATION => MultiWordTitleRecommendation::class,
            self::EVEN_LETTERS_WITH_LETTER_W_IN_TITLE_RECOMMENDATION
            => EvenLettersInTitleAndStartsWithLetterWRecommendation::class,
        };
    }
}
