<?php

namespace App\Http\Controllers\SubDealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Auth;
use App\Models\User;
use App\Models\SubDealer;
use App\Models\SubOrder;
use App\Models\SubOrderList;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Currency;
use App\Models\DealerPercentage;
use Mail;
use App\Mail\Dealer\OrderMail;

class SubDealerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartList = SubDealer::userCartProductList();
        $currentuserid = Auth::user()->id;
        $currentuserDealerId = Auth::user()->dealer_id;
        $currentuserCurrency = Auth::user()->currency;
        $getRate = Currency::where('country_currency','=',$currentuserCurrency)->first();
        $rate = $getRate->rate;
        $getPercentage = DealerPercentage::where([['dealer_id','=',$currentuserDealerId],['sub_dealer_id','=',$currentuserid]])->first();
        $dealerPercentage = $getPercentage->percentage;
        return view('subdealerorder.view',  ['allCartList' => $cartList,'rate'=> $rate,'userCurrency' => $currentuserCurrency, 'dealerPercentage' => $dealerPercentage]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $currentuserid = Auth::user()->id;
        $dealerId = Auth::user()->dealer_id;
        $dealerEmail = User::select('email')->where('id',$dealerId)->first();
        $prefix = "SN-SD-";  
        $order_id = IdGenerator::generate(['table' => 'sub_orders','field'=>'order_id' ,'length' => 12, 'prefix' => $prefix]);
        $placeOrderId = SubDealer::orderPlace($order_id);
        if ($placeOrderId == true) {
            SubDealer::where('user_id', $currentuserid)->delete();
            $mailData = [
                'order_id' => $order_id,
                'dealer_name' => Auth::user()->dealer_name
            ];
            $mail_to = explode(',', env('MAIL_TO'));
            $dealer_email_to = $dealerEmail->email;
            Mail::to($mail_to)->send(new OrderMail($mailData));
            Mail::to($dealer_email_to)->send(new OrderMail($mailData));
            Mail::to('shamjit@shamsnaturals.com')->send(new OrderMail($mailData));
            
            return redirect()->route('subdealerorder.show')->with('success', 'Order has been placed successfully.');
        } else {
            return redirect()->route('subdealerorder.show')->with('error', 'Error Occured While Placing Order. Kindly try again.');
        }

        
    }

    /**
     * Store a newly created resource in storage.
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

        $checkActualQty = Product::join('stocks', 'products.product_code', '=' , 'stocks.product_code')
                          ->select('stocks.stock_qty', 'stocks.coming_soon')
                          ->where('products.id', '=', $request->product_id)->first();
        if (($request->order_quantity > $checkActualQty->stock_qty) && ($checkActualQty->coming_soon == '0')) {
            exit();
        }


        $getTempOrderDataCount = SubDealer::where([
            ['user_id',$currentuserid],
            ['product_id',$request->product_id]
        ])->count();
        
        if($getTempOrderDataCount == 0) {
            $insertData = new SubDealer();
            $insertData->user_id = $currentuserid;
            $insertData->product_id = $request->product_id;
            $insertData->order_quantity = $request->order_quantity;
            $insertData->save();
            $getTotalProductAdded = SubDealer::where('user_id',$currentuserid)->count();
            
            return $getTotalProductAdded;
        } else {
            $getTempOrderData = SubDealer::where([
                ['user_id',$currentuserid],
                ['product_id',$request->product_id]
            ])->first();
            
            $id = $getTempOrderData->id;
            $updateData = SubDealer::findOrFail($id);
            $updateData->order_quantity = $request->order_quantity;
            $updateData->save();
            $getTotalProductAdded = SubDealer::where('user_id',$currentuserid)->count();
            
            return $getTotalProductAdded;

        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $currentuserid = Auth::user()->id;
        $allOrderList = SubOrder::where('user_id','=',$currentuserid)->orderByDesc('order_id')->get();

        return view('subdealerorder.orderview',  ['allOrderList' => $allOrderList]);
    }

    public function ordershow(string $id)
    {
        $order_id = strip_tags($id);
        $orderDetails = SubDealer::orderDetails($order_id);
        $allorderProductList = SubOrderList::productList($order_id);

        return view('subdealerorder.vieworder',  ['orderDetails' => $orderDetails, 'allorderProductList' => $allorderProductList]); 
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

        $getTempOrderData = SubDealer::where([
            ['user_id',$currentuserid],
            ['product_id',$request->product_id]
        ])->first();

        if ($getTempOrderData) {
            SubDealer::where('id', $getTempOrderData->id)->delete();
            $getTotalProductAdded = SubDealer::where('user_id',$currentuserid)->count();
            return $getTotalProductAdded;
        } else {
            return 'notfound';
        }

    }
}