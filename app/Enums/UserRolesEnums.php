<?php
  
namespace App\Enums;
 
enum UserRolesEnums:string {
    case Admin = 'admin';
    case Manager = 'manager';
    case Dealer = 'dealer';
}