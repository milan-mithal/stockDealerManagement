<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\CommonStatusEnums;
use App\Models\Stock;
use Auth;

class Dealer extends Model
{
    use HasFactory;

    protected $table = 'temp_order_list';

    protected $fillable = [
        'id', 'user_id', 'product_id', 'order_quantity'
    ];


    public static function productList() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('products')
            ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
            ->leftJoin('temp_order_list', function ($join) use ($currentuserid) {
                $join->on('products.id', '=', 'temp_order_list.product_id')
                     ->where('temp_order_list.user_id', '=', $currentuserid);
            })
            ->select('products.*','stocks.stock_qty as total_stock_qty', 'stocks.stock_sold_qty as total_stock_sold_qty', 'temp_order_list.order_quantity as ordered_qty')
            ->where('products.status', CommonStatusEnums::Active)
            ->get();

        return $data;
    }

    public static function userCartProductList() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('temp_order_list')
                ->join('products', 'temp_order_list.product_id', '=' , 'products.id')
                ->select('products.product_name as product_name', 'products.product_code as product_code', 'products.product_image as product_image', 'product_price as product_price', 'temp_order_list.id as temp_order_id' ,'temp_order_list.order_quantity as order_quantity')
                ->where('temp_order_list.user_id', '=', $currentuserid)
                ->get();

        return $data;
    }

    public static function orderPlace($order_id) {
        $currentuserid = Auth::user()->id;
        $totalAmount = 0;
        $orderStatus = 'Order Placed';
        $orderRemarks = 'Order has been placed';
        $data = DB::table('temp_order_list')
                ->join('products', 'temp_order_list.product_id', '=' , 'products.id')
                ->join('stocks', 'products.product_code', '=' , 'stocks.product_code')
                ->select('products.product_name as product_name', 'products.product_code as product_code', 'products.product_category as product_category', 'products.product_size as product_size','products.product_price as product_price','temp_order_list.order_quantity as order_quantity', 'stocks.stock_qty as stock_qty', 'stocks.stock_sold_qty as stock_sold_qty')
                ->where('temp_order_list.user_id', '=', $currentuserid)
                ->get();
        foreach ($data as $row) {
            
            DB::table('order_list')->insert([
                'order_id' => $order_id,
                'product_code' => $row->product_code,
                'product_name' => $row->product_name,
                'product_category' => $row->product_category,
                'product_size' => $row->product_size,
                'product_price' => $row->product_price,
                'order_quantity' => $row->order_quantity,
                'order_status' => $orderStatus,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
            $product_code = $row->product_code;
            $stock_qty = $row->stock_qty - $row->order_quantity;
            $stock_sold_qty = $row->stock_sold_qty + $row->order_quantity;
            $productQtyUpdate = Stock::where('product_code', '=', $product_code)
                                ->update([
                                    'stock_qty' => $stock_qty,
                                    'stock_sold_qty' => $stock_sold_qty,
                                ]);
            
            $totalAmount += $row->product_price * $row->order_quantity;
        }

        $orderPlaceId = DB::table('orders')->insertGetId([
            'order_id' => $order_id,
            'user_id' => $currentuserid,
            'total_amount' => $totalAmount,
            'order_status' => $orderStatus,
            'order_remarks' => $orderRemarks,
            'order_date' => date('Y-m-d'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return $orderPlaceId;
    }
}
