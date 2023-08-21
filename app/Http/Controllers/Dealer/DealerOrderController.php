<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Auth;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\OrderList;

class DealerOrderController extends Controller
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
        $cartList = Dealer::userCartProductList();
        return view('dealerorder.view',  ['allCartList' => $cartList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $currentuserid = Auth::user()->id;
        $prefix = "SN-".date("my")."-";  
        $order_id = IdGenerator::generate(['table' => 'orders','field'=>'order_id' ,'length' => 15, 'prefix' =>$prefix]);
        $placeOrderId = Dealer::orderPlace($order_id);
        if ($placeOrderId) {
            Dealer::where('user_id', $currentuserid)->delete();
        }
        
        return redirect()->route('dealerorder.show')->with('success', 'Order has been placed successfully.');
    }

    /**
     * Store a newly created resource in storage.
     * Also updating resource
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'product_id' => 'numeric',
            'order_quantity' => 'min:1|numeric', 
        ], [
            'product_id.numeric' => 'Product Id should be numeric.',
            'order_quantity.min' => 'Order quantity cannot be less than 1.',
            'order_quantity.numeric' => 'Order quantity should be numeric.',
        ]);
        
        $currentuserid = Auth::user()->id;

        $getTempOrderData = Dealer::where([
            ['user_id',$currentuserid],
            ['product_id',$request->product_id]
        ])->first();

      
        if ($getTempOrderData) {
            $id = $getTempOrderData->id;
            $updateData = Dealer::findOrFail($id);
            $updateData->order_quantity = $request->order_quantity;
            $updateData->save();
            $getTotalProductAdded = Dealer::where('user_id',$currentuserid)->count();
            
            return $getTotalProductAdded;
        } 

        $insertData = new Dealer();
        $insertData->user_id = $currentuserid;
        $insertData->product_id = $request->product_id;
        $insertData->order_quantity = $request->order_quantity;
        $insertData->save();
        $getTotalProductAdded = Dealer::where('user_id',$currentuserid)->count();
        
        return $getTotalProductAdded;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $currentuserid = Auth::user()->id;
        $allOrderList = Order::where('user_id','=',$currentuserid)->get();

        return view('dealerorder.orderview',  ['allOrderList' => $allOrderList]);
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
    public function destroy(Request $request)
    {
        $currentuserid = Auth::user()->id;

        $getTempOrderData = Dealer::where([
            ['user_id',$currentuserid],
            ['product_id',$request->product_id]
        ])->first();

        if ($getTempOrderData) {
            Dealer::where('id', $getTempOrderData->id)->delete();
            $getTotalProductAdded = Dealer::where('user_id',$currentuserid)->count();
            return $getTotalProductAdded;
        } else {
            return 'notfound';
        }

    }
}
