<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubOrderList extends Model
{
    use HasFactory;

    protected $table = 'sub_orders_list';

    protected $fillable = [
        'id', 'order_id', 'product_code', 'product_name', 'product_category', 'product_size', 'product_price', 'order_quantity', 'order_status'
    ];

    public static function productList($order_id) 
    {
        $data = DB::table('sub_orders_list')
            ->leftJoin('product_category', 'sub_orders_list.product_category', '=', 'product_category.id')
            ->select('sub_orders_list.*','product_category.category_name as cat_name')
            ->where('sub_orders_list.order_id', $order_id)
            ->get();
        return $data;
    }

}