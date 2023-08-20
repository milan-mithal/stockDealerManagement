<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\CommonStatusEnums;
use Auth;

class Dealer extends Model
{
    use HasFactory;

    protected $table = 'temp_order_list';

    protected $fillable = [
        'id', 'user_id', 'product_id', 'order_quantity'
    ];


    public static function productList()
    {
        $currentuserid = Auth::user()->id;
        $data = DB::table('products')
            ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
            ->leftJoin('temp_order_list', function ($join) use ($currentuserid) {
                $join->on('products.id', '=', 'temp_order_list.product_id')
                     ->where('temp_order_list.user_id', '=', $currentuserid);
            })
            ->select('products.*','stocks.stock_qty as total_stock_qty', 'temp_order_list.order_quantity as ordered_qty')
            ->where('products.status', CommonStatusEnums::Active)
            ->get();

        return $data;
    }
}
