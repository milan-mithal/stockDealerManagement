<?php 

namespace App\Enums;
 
enum OrderStatusEnums:string {
    case Placed = 'placed';
    case Received = 'received';
    case Packed = 'packed';
    case Ready = 'ready';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
