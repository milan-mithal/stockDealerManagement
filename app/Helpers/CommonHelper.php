<?php

namespace App\Helpers;

class CommonHelper
{
    public static function mainCategory($mainCat)
    {
        $categories = [
            1 => 'Naturals',
            2 => 'Essentials'
        ];

        return $categories[$value] ?? 'Unknown Category';
    }
}