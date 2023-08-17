<?php
  
namespace App\Enums;
 
enum UserStatusEnums:string {
    case Pending = 'pending';
    case Active = 'active';
    case Inactive = 'inactive';
    case Rejected = 'rejected';
}