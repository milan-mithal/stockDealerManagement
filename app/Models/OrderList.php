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

    public static function cancelledOrderQtyAddedBack($order_id) {
        $update = DB::table('order_list')
        ->join('stocks', 'order_list.product_code', '=', 'stocks.product_code')
        ->where('order_list.order_id', $order_id)
        ->update([
            'stocks.stock_qty' => DB::raw('stocks.stock_qty + order_list.order_quantity'),
            'stocks.stock_sold_qty' => DB::raw('stocks.stock_sold_qty - order_list.order_quantity')
        ]);

    return $update;
    }

}