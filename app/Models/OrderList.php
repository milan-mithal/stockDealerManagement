<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class OrderList extends Model
{
    use HasFactory;

    protected $table = 'order_list';

    protected $fillable = [
        'id', 'order_id', 'product_code', 'product_name', 'product_category', 'product_size', 'product_price', 'order_quantity', 'order_status'
    ];

}
