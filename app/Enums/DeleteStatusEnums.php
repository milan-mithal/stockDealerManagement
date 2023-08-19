<?php 

namespace App\Enums;
 
enum DeleteStatusEnums:string {
    case Deleted = 'deleted';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
