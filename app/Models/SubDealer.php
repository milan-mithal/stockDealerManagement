<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\CommonStatusEnums;
use App\Models\Stock;
use App\Models\SubOrderList;
use App\Models\Currency;
use App\Models\DealerPercentage;
use Auth;

class SubDealer extends Model
{
    use HasFactory;

    protected $table = 'temp_order_list';

    protected $fillable = [
        'id', 'user_id', 'product_id', 'order_quantity'
    ];


    public static function productList() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('products')
            ->join('product_category', 'products.product_category', '=', 'product_category.id')
            ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
            ->leftJoin('temp_order_list', function ($join) use ($currentuserid) {
                $join->on('products.id', '=', 'temp_order_list.product_id')
                     ->where('temp_order_list.user_id', '=', $currentuserid);
            })
            ->select('products.*','product_category.category_name as catName','stocks.stock_qty as total_stock_qty', 'stocks.coming_soon as coming_soon','stocks.stock_coming_soon as stock_coming_soon','stocks.stock_sold_qty as total_stock_sold_qty', 'temp_order_list.order_quantity as ordered_qty')
            ->where('products.status', CommonStatusEnums::Active)
            ->get();

        return $data;
    }

    public static function userCartProductList() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('temp_order_list')
                ->join('products', 'temp_order_list.product_id', '=' , 'products.id')
                ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
                ->select('products.id as id','products.product_name as product_name', 'products.product_code as product_code', 'products.product_image as product_image', 'product_price as product_price', 'temp_order_list.id as temp_order_id' ,'temp_order_list.order_quantity as order_quantity','stocks.stock_qty as total_stock_qty','stocks.coming_soon as coming_soon', 'stocks.stock_coming_soon as stock_coming_soon','stocks.stock_sold_qty as total_stock_sold_qty')
                ->where('temp_order_list.user_id', '=', $currentuserid)
                ->get();

        return $data;
    }

    public static function orderPlace($order_id) {
        $currentuserid = Auth::user()->id;
        $currentuserDealerId = Auth::user()->dealer_id;
        $currentuserCurrency = Auth::user()->currency;
        $getRate = Currency::where('country_currency','=',$currentuserCurrency)->first();
        $rate = $getRate->rate;
        $getPercentage = DealerPercentage::where([['dealer_id','=',$currentuserDealerId],['sub_dealer_id','=',$currentuserid]])->first();
        $dealerPercentage = $getPercentage->percentage;
        $totalAmount = 0;
        $orderStatus = 'Order Placed';
        $orderRemarks = 'Order has been placed';
        $data = DB::table('temp_order_list')
                ->join('products', 'temp_order_list.product_id', '=' , 'products.id')
                ->join('stocks', 'products.product_code', '=' , 'stocks.product_code')
                ->select('products.*','temp_order_list.order_quantity as order_quantity', 'stocks.stock_qty as stock_qty', 'stocks.stock_sold_qty as stock_sold_qty')
                ->where('temp_order_list.user_id', '=', $currentuserid)
                ->get();
        foreach ($data as $row) {
            $orderListExist = SubOrderList::where([['order_id',$order_id],['product_code',$row->product_code]])->count();
            if ($orderListExist == 0) {
                 //Total Boxes
                 $totalBoxes = ceil($row->order_quantity/$row->qty_per_box);
                 //Total Weight
                 $totalWeight = ceil($totalBoxes*$row->weight_per_box);
                 //CBM
                 $lwh = ($row->length*$row->width*$row->height)/1000000;
                 $cmb = round($lwh*$totalBoxes,3);

                 $box_dimension = $row->length."X".$row->width."X".$row->height;

                 //Currecy Calculation
                $originalProductPrice = $row->product_price;
                
                if($currentuserCurrency == 'AED' && $dealerPercentage <= 0)
                {
                    $productPercentagePrice = $originalProductPrice;
                    $rateConversion = $productPercentagePrice;
                } else if($currentuserCurrency != 'AED' && $dealerPercentage <= 0) {
                            $productPercentagePrice = $originalProductPrice;
                            $rateConversion = $productPercentagePrice * $rate;
                } else if($currentuserCurrency == 'AED' && $dealerPercentage > 0) {
                    $productPercentagePrice = ($originalProductPrice * $dealerPercentage)/100 + $originalProductPrice;
                    $rateConversion = $productPercentagePrice;
                }
                else {
                    $productPercentagePrice = ($originalProductPrice * $dealerPercentage)/100 + $originalProductPrice;
                    $rateConversion = $productPercentagePrice * $rate;
                }
                $finalPrice = round($rateConversion,2);


                DB::table('sub_orders_list')->insert([
                    'order_id' => $order_id,
                    'product_code' => $row->product_code,
                    'product_name' => $row->product_name,
                    'product_category' => $row->product_category,
                    'product_size' => $row->product_size,
                    'original_product_price' => $originalProductPrice,
                    'product_price' => $finalPrice,
                    'order_quantity' => $row->order_quantity,
                    'total_boxes' => $totalBoxes,
                    'weight_per_box' => $row->weight_per_box,
                    'box_dimension' => $box_dimension,
                    'cbm' => $cmb, 
                    'order_status' => $orderStatus,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
                /**
                 * QTY Detected on placing order
                 */
                // $product_code = $row->product_code;
                // $stock_qty = $row->stock_qty - $row->order_quantity;
                // $stock_sold_qty = $row->stock_sold_qty + $row->order_quantity;
                // $productQtyUpdate = Stock::where('product_code', '=', $product_code)
                //                     ->update([
                //                         'stock_qty' => $stock_qty,
                //                         'stock_sold_qty' => $stock_sold_qty,
                //                     ]);
                
                $totalAmount += $finalPrice * $row->order_quantity;
                 

            }
            
        }

        $orderListExist_2 = SubOrderList::where([['order_id',$order_id]])->count();
        if ($orderListExist_2 > 0)
        {

        $orderPlaceId = DB::table('sub_orders')->insertGetId([
            'order_id' => $order_id,
            'dealer_id' =>  $currentuserDealerId,
            'user_id' => $currentuserid,
            'total_amount' => $totalAmount,
            'order_status' => $orderStatus,
            'order_remarks' => $orderRemarks,
            'currency' => $currentuserCurrency,
            'percentage' => $dealerPercentage,
            'rate' => $rate,
            'order_date' => date('Y-m-d'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        return true;
        } else {
            return false;
        }
        
    }

    public static function orderDetails($order_id) {
        $data = DB::table('sub_orders')
                ->join('users', 'sub_orders.user_id', '=' , 'users.id')
                ->select('users.name as user_name', 'users.email as user_email','users.dealer_name as dealer_name','users.address as address',
                'users.region as region','users.community as community','users.phone_no as phone_no','sub_orders.id as id', 'sub_orders.order_id as order_id', 'sub_orders.total_amount as total_amount','sub_orders.order_status as order_status' ,'sub_orders.order_remarks as order_remarks','sub_orders.order_date as order_date')
                ->where('sub_orders.order_id', '=', $order_id)
                ->first();

        return $data;
    }
}