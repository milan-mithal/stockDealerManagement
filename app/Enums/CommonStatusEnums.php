<?php 

namespace App\Enums;
 
enum CommonStatusEnums:string {
    case Active = 'active';
    case Inactive = 'inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
