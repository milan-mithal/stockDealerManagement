<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Stock;
use Mail;
use App\Mail\Stock\StockMail;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allNewOrders = Order::select('users.dealer_name', 'users.user_code','orders.order_id')
                        ->join('users', 'users.id', '=', 'orders.user_id')
                        ->where('orders.order_status', '=', 'Order Placed')
                        ->get();
        $allNewOrdersCount = $allNewOrders->count();

        return response()->json([
            'newOrderCount' => $allNewOrdersCount,
            'newOrders' => $allNewOrders
        ]);
    }

    /**
     * Check out of stock products
     */
    public function checkoutofstock()
    {
        $allOutOfStockProducts = Stock::select('product_code','stock_qty')
                        ->whereColumn('stock_qty', '<=', 'stock_min_qty')
                        ->get();

        $allOutOfStockProductsCount = $allOutOfStockProducts->count();
        
        if($allOutOfStockProductsCount > 0) {
            $mailData = [
                'allOutOfStockProducts' => $allOutOfStockProducts,
            ];

            $mail_to = env('MAIL_TO');
            Mail::to($mail_to)->send(new StockMail($mailData));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
