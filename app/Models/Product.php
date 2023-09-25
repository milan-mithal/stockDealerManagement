<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id', 'product_name', 'product_code', 'prdouct_image', 'status', 'product_category' , 'product_size', 'product_price', 'length', 'width', 'height', 'qty_per_box', 'weight_per_box'
    ];

    
}
