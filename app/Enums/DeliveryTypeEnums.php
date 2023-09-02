<?php
  
namespace App\Enums;
 
enum DeliveryTypeEnums:string {
    case Driver = 'driver';
    case Third_Party = 'third_party';
    case Delivery = 'delivery';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}