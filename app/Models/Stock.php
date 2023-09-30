<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\CommonStatusEnums;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'id', 'product_code', 'stock_qty', 'stock_sold_qty', 'stock_min_qty', 'coming_soon', 'stock_coming_soon'
    ];


    public static function productList()
    {
        $data = DB::table('products')
            ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
            ->select('products.product_code', 'products.product_category','products.status','stocks.id','stocks.coming_soon','stocks.stock_qty','stocks.stock_coming_soon', 'stocks.stock_sold_qty', 'stocks.stock_min_qty')
            ->where('products.status', CommonStatusEnums::Active)
            ->orWhere('products.status', CommonStatusEnums::Inactive)
            ->get();

        return $data;
    }
}
