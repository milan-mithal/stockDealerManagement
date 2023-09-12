<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Order;
use App\Models\User;
use Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
        $this->middleware('checkrole');
    }
    public function stockreport() 
    {
        $stockList = Stock::productList();
        return view('report.stock',  ['allStockList' => $stockList]);
    }

    public function dealerreport() 
    {
        $dealersWithOrderCounts = Order::join('users', 'users.id', '=', 'orders.user_id')
        ->groupBy('orders.user_id', 'users.dealer_name')
        ->selectRaw('users.dealer_name as dealer_name, COUNT(orders.user_id) as order_count, MAX(orders.total_amount) as total_amount')
        ->get();
        return view('report.dealer',  ['allDealerswithOrderCounts' => $dealersWithOrderCounts]);
    }

    public function orderreport() 
    {
        return view('report.order');
    }

    public function orderdata(Request $request) 
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required'
        ], [
            'from_date.required' => 'Please select from date.',
            'to_date.required' => 'Please select to date.',
        ]);
        $from_date = $request->from_date;
        $to_data = $request->to_date;



        $allOrders = Order::join('users', 'users.id', '=', 'orders.user_id')
        ->select('users.name as user_name','users.user_code as user_code', 'users.email as user_email','users.dealer_name as dealer_name','users.address as address',
        'users.region as region','users.community as community','users.phone_no as phone_no','orders.id as id', 'orders.order_id as order_id', 'orders.total_amount as total_amount', 'orders.delivery_type as delivery_type','orders.delivery_details as delivery_details', 'orders.order_status as order_status' ,'orders.order_remarks as order_remarks','orders.order_date as order_date')
        ->whereBetween('orders.order_date', [$from_date, $to_data])
        ->orderby('orders.order_id','desc')
        ->get();
        return view('report.order',  ['allOrderDetails' => $allOrders]);

    }


}
