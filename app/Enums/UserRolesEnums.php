<?php
  
namespace App\Enums;
 
enum UserRolesEnums:string {
    case Admin = 'admin';
    case Manager = 'manager';
    case Dealer = 'dealer';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}