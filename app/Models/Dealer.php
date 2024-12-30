<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\MainCategoryEnums;
use App\Enums\CommonStatusEnums;
use App\Models\Stock;
use App\Models\OrderList;
use App\Helpers\CommonHelper;
use Auth;
class Dealer extends Model
{
    use HasFactory;
    protected $table = 'temp_order_list';
    protected $fillable = [
        'id', 'user_id', 'product_id', 'order_quantity'
    ];
    public static function productListNatural() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('products')
            ->join('product_category', 'products.product_category', '=', 'product_category.id')
            ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
            ->leftJoin('temp_order_list', function ($join) use ($currentuserid) {
                $join->on('products.id', '=', 'temp_order_list.product_id')
                     ->where('temp_order_list.user_id', '=', $currentuserid);
            })
            ->select('products.*','product_category.category_name as catName','stocks.stock_qty as total_stock_qty', 'stocks.coming_soon as coming_soon','stocks.stock_coming_soon as stock_coming_soon','stocks.stock_sold_qty as total_stock_sold_qty', 'temp_order_list.order_quantity as ordered_qty')
            ->where('products.main_category', MainCategoryEnums::Naturals)
            ->where('products.status', CommonStatusEnums::Active)
            ->get();
        return $data;
    }
    public static function productListEssentials() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('products')
            ->join('product_category', 'products.product_category', '=', 'product_category.id')
            ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
            ->leftJoin('temp_order_list', function ($join) use ($currentuserid) {
                $join->on('products.id', '=', 'temp_order_list.product_id')
                     ->where('temp_order_list.user_id', '=', $currentuserid);
            })
            ->select('products.*','product_category.category_name as catName','stocks.stock_qty as total_stock_qty', 'stocks.coming_soon as coming_soon','stocks.stock_coming_soon as stock_coming_soon','stocks.stock_sold_qty as total_stock_sold_qty', 'temp_order_list.order_quantity as ordered_qty')
            ->where('products.main_category', MainCategoryEnums::Essentials)
            ->where('products.status', CommonStatusEnums::Active)
            ->get();
        return $data;
    }
    public static function userCartProductList() {
        $currentuserid = Auth::user()->id;
        $data = DB::table('temp_order_list')
                ->join('products', 'temp_order_list.product_id', '=' , 'products.id')
                ->join('stocks', 'products.product_code', '=', 'stocks.product_code')
                ->select('products.id as id','products.product_name as product_name', 'products.product_code as product_code', 'products.product_image as product_image', 'product_price as product_price','percentage as percentage','main_category as main_category', 'temp_order_list.id as temp_order_id' ,'temp_order_list.order_quantity as order_quantity','stocks.stock_qty as total_stock_qty','stocks.coming_soon as coming_soon', 'stocks.stock_coming_soon as stock_coming_soon','stocks.stock_sold_qty as total_stock_sold_qty')
                ->where('temp_order_list.user_id', '=', $currentuserid)
                ->get();
        return $data;
    }
    public static function orderPlace($order_id,$delivery_type,$third_party_details,$delivery_details) {
        $currentuserid = Auth::user()->id;
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
            $orderListExist = OrderList::where([['order_id',$order_id],['product_code',$row->product_code]])->count();
            if ($orderListExist == 0) {
                 //Total Boxes
                 $totalBoxes = ceil($row->order_quantity/$row->qty_per_box);
                 //Total Weight
                 $totalWeight = ceil($totalBoxes*$row->weight_per_box);
                 //CBM
                 $lwh = ($row->length*$row->width*$row->height)/1000000;
                 $cmb = round($lwh*$totalBoxes,3);
                 $box_dimension = $row->length."X".$row->width."X".$row->height;
                $set_price = CommonHelper::calculatePrice($row->product_price, $row->percentage, $row->main_category);
                DB::table('order_list')->insert([
                    'order_id' => $order_id,
                    'product_code' => $row->product_code,
                    'product_name' => $row->product_name,
                    'product_category' => $row->product_category,
                    'product_size' => $row->product_size,
                    'original_price' => $row->product_price,
                    'product_price' => $set_price,
                    'order_quantity' => $row->order_quantity,
                    'total_boxes' => $totalBoxes,
                    'weight_per_box' => $row->weight_per_box,
                    'box_dimension' => $box_dimension,
                    'cbm' => $cmb, 
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
                $totalAmount += $set_price * $row->order_quantity;
            }
        }
        $orderListExist_2 = OrderList::where([['order_id',$order_id]])->count();
        if ($orderListExist_2 > 0)
        {
            $orderPlaceId = DB::table('orders')->insertGetId([
                'order_id' => $order_id,
                'user_id' => $currentuserid,
                'total_amount' => $totalAmount,
                'order_status' => $orderStatus,
                'order_remarks' => $orderRemarks,
                'order_date' => date('Y-m-d'),
                'delivery_type' => $delivery_type,
                'third_party_details' => $third_party_details,
                'delivery_details' => $delivery_details,
                'courier_company' => '',
                'awb_number' => '',
                'deliver_bill_upload' => '',
                'modified_by' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
            return true;
        } else {
            return false;
        }
    }
    public static function orderDetails($order_id) {
        $data = DB::table('orders')
                ->join('users', 'orders.user_id', '=' , 'users.id')
                ->select('users.name as user_name', 'users.email as user_email','users.dealer_name as dealer_name','users.address as address',
                'users.region as region','users.community as community','users.phone_no as phone_no','orders.id as id', 'orders.order_id as order_id', 'orders.total_amount as total_amount','orders.delivery_type as delivery_type','orders.third_party_details as third_party_details', 'orders.order_status as order_status' ,'orders.order_remarks as order_remarks','orders.order_date as order_date')
                ->where('orders.order_id', '=', $order_id)
                ->first();
        return $data;
    }
}