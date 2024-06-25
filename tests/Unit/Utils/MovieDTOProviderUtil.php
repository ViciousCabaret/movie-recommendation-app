<?php

namespace App\Tests\Unit\Utils;

use App\DTO\MovieDTO;

class MovieDTOProviderUtil
{
    public static function createMovieDTOFromTitleList(array $titleList): array
    {
        $result = [];
        foreach ($titleList as $title) {
            $result[] = new MovieDTO($title);
        }

        return $result;
    }
}