<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
