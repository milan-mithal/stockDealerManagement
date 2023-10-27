<?php
  
namespace App\Enums;
 
enum UserRolesEnums:string {
    case Admin = 'admin';
    case Packing = 'packing';
    case Dealer = 'dealer';
    case Sub_Dealer = 'subdealer';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}