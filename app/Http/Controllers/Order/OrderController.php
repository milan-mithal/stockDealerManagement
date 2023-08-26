<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Validation\Rules\Enum;
use App\Models\Order;
use App\Models\OrderList;
use App\Enums\OrderStatusEnums;
use Auth;



class OrderController extends Controller
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
        $allOrderList = Order::allOrderDetails();

        return view('order.view',  ['allOrderList' => $allOrderList]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
        $order_id = strip_tags($id);
        $orderDetails = Order::orderDetails($order_id);
        $allorderProductList = OrderList::where('order_id', '=' , $order_id)->get();

        return view('order.vieworder',  ['orderDetails' => $orderDetails, 'allorderProductList' => $allorderProductList]); 

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
        $request->validate([
            'order_status' => ['required', new Enum(OrderStatusEnums::class)],
            'order_remarks' => 'required',
        ], [
            'order_status.required' => 'Please choose order status.',
            'order_remarks.required' => 'Please enter order remarks.',
        ]);
        

        $updateData = Order::findOrFail($id);
        $updateData->order_status = $request->order_status;
        $updateData->order_remarks = $request->order_remarks;
        $updateData->save();
    
        return redirect()->route('order.index')->with('success', 'Order Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
