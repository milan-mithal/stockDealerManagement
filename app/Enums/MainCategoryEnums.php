<?php 

namespace App\Enums;
 
enum MainCategoryEnums:string {
    case Naturals = 'naturals';
    case Essentials = 'essentials';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}