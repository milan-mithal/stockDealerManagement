<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id', 'order_id', 'user_id', 'total_amount', 'order_status', 'order_remarks', 'order_date'
    ];

    public static function allOrderDetails() {
        $data = DB::table('orders')
                ->join('users', 'orders.user_id', '=' , 'users.id')
                ->select('users.name as user_name', 'users.email as user_email','users.dealer_name as dealer_name','users.address as address',
                'users.region as region','users.community as community','users.phone_no as phone_no','orders.id as id', 'orders.order_id as order_id', 'orders.total_amount as total_amount', 'orders.order_status as order_status' ,'orders.order_remarks as order_remarks','orders.order_date as order_date')
                ->orderby('orders.order_id','desc')
                ->get();
        return $data;
    }

    public static function orderDetails($order_id) {
        $data = DB::table('orders')
                ->join('users', 'orders.user_id', '=' , 'users.id')
                ->select('users.name as user_name', 'users.email as user_email','users.dealer_name as dealer_name','users.address as address',
                'users.region as region','users.community as community','users.phone_no as phone_no','orders.id as id', 'orders.order_id as order_id', 'orders.total_amount as total_amount', 'orders.order_status as order_status' ,'orders.order_remarks as order_remarks','orders.order_date as order_date')
                ->where('orders.order_id', '=', $order_id)
                ->first();

        return $data;
    }    
}
