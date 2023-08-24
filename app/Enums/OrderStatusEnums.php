<?php 

namespace App\Enums;
 
enum OrderStatusEnums:string {
    case Accepted = 'accepted';
    case Packed = 'packed';
    case Dispatched = 'dispatched';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
