<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\CommonStatusEnums;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id', 'product_name', 'product_code', 'prdouct_image', 'status', 'product_category' , 'product_size', 'product_price', 'length', 'width', 'height', 'qty_per_box', 'weight_per_box'
    ];

    public static function productList()
    {
        $data = DB::table('products')
            ->leftJoin('product_category', 'products.product_category', '=', 'product_category.id')
            ->select('products.*','product_category.category_name as cat_name')
            ->where('products.status', CommonStatusEnums::Active)
            ->orWhere('products.status', CommonStatusEnums::Inactive)
            ->get();
        return $data;
    }

    
}