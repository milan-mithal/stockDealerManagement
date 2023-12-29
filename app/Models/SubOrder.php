<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class SubOrder extends Model
{
    use HasFactory;

    protected $table = 'sub_orders';

    protected $fillable = [
        'id', 'order_id', 'user_id', 'total_amount', 'order_status','order_placed', 'order_remarks', 'order_date'
    ];

    public static function allOrderDetails() {
        $data = DB::table('sub_orders')
                ->join('users', 'sub_orders.user_id', '=' , 'users.id')
                ->select('users.name as user_name','users.user_code as user_code', 'users.email as user_email','users.dealer_name as dealer_name','users.address as address',
                'users.region as region','users.community as community','users.phone_no as phone_no','sub_orders.id as id', 'sub_orders.order_id as order_id', 'sub_orders.total_amount as total_amount', 'sub_orders.order_status as order_status' ,'sub_orders.order_remarks as order_remarks','sub_orders.order_date as order_date')
                ->orderby('sub_orders.order_id','desc')
                ->get();
        return $data;
    }

    public static function orderDetails($order_id) {
        $data = DB::table('sub_orders')
                ->join('users', 'sub_orders.user_id', '=' , 'users.id')
                ->select('users.name as user_name',
                'users.user_code as user_code',
                'users.email as user_email',
                'users.dealer_name as dealer_name',
                'users.address as address',
                'users.region as region',
                'users.community as community',
                'users.phone_no as phone_no',
                'sub_orders.id as id', 
                'sub_orders.order_id as order_id', 
                'sub_orders.total_amount as total_amount', 
                'sub_orders.order_status as order_status' ,
                'sub_orders.order_placed as order_placed',
                'sub_orders.order_remarks as order_remarks',
                'sub_orders.currency as currency',
                'sub_orders.order_date as order_date')
                ->where('sub_orders.order_id', '=', $order_id)
                ->first();

        return $data;
    }  

}