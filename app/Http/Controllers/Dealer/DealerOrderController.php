<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Auth;
use App\Models\User;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use App\Models\Stock;
use App\Models\SubOrder;
use App\Models\SubOrderList;
use Mail;
use App\Mail\Dealer\OrderMail;
use App\Mail\Order\OrderStatusMail;

class DealerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
        $this->middleware('checkroleboth');
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

        $request->validate([
            'delivery_by' => 'required',
            'third_party_details' => 'required_if:delivery_by,==,third_party', 
            'delivery_details' => 'required_if:delivery_by,==,delivery', 
        ], [
            'delivery_by.required' => 'Please select pickup by.',
            'third_party_details.required_if' => 'Please enter third party details.',
            'delivery_details.required_if' => 'Please enter delivery details.'
        ]);


        $currentuserid = Auth::user()->id;
        $delivery_type = $request->delivery_by;
        $third_party_details = "";
        if ($request->delivery_by == 'third_party') {
            $third_party_details = $request->third_party_details;
        }
        $delivery_details = "";
        if ($request->delivery_by == 'delivery') {
            $delivery_details = $request->delivery_details;
        }

        $prefix = "SN-";  
        $order_id = IdGenerator::generate(['table' => 'orders','field'=>'order_id' ,'length' => 10, 'prefix' => $prefix]);
        $placeOrderId = Dealer::orderPlace($order_id,$delivery_type,$third_party_details,$delivery_details);
        if ($placeOrderId == true) {
            Dealer::where('user_id', $currentuserid)->delete();
            $mailData = [
                'order_id' => $order_id,
                'dealer_name' => Auth::user()->dealer_name
            ];
            $mail_to = explode(',', env('MAIL_TO'));
            Mail::to($mail_to)->send(new OrderMail($mailData));
            
            return redirect()->route('dealerorder.show')->with('success', 'Order has been placed successfully.');
        } else {
            return redirect()->route('dealerorder.show')->with('error', 'Error Occured While Placing Order. Kindly try again.');
        }

        
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

        $checkActualQty = Product::join('stocks', 'products.product_code', '=' , 'stocks.product_code')
                          ->select('stocks.stock_qty', 'stocks.coming_soon')
                          ->where('products.id', '=', $request->product_id)->first();
        if (($request->order_quantity > $checkActualQty->stock_qty) && ($checkActualQty->coming_soon == '0')) {
            exit();
        }


        $getTempOrderDataCount = Dealer::where([
            ['user_id',$currentuserid],
            ['product_id',$request->product_id]
        ])->count();
        
        if($getTempOrderDataCount == 0) {
            $insertData = new Dealer();
            $insertData->user_id = $currentuserid;
            $insertData->product_id = $request->product_id;
            $insertData->order_quantity = $request->order_quantity;
            $insertData->save();
            $getTotalProductAdded = Dealer::where('user_id',$currentuserid)->count();
            
            return $getTotalProductAdded;
        } else {
            $getTempOrderData = Dealer::where([
                ['user_id',$currentuserid],
                ['product_id',$request->product_id]
            ])->first();
            
            $id = $getTempOrderData->id;
            $updateData = Dealer::findOrFail($id);
            $updateData->order_quantity = $request->order_quantity;
            $updateData->save();
            $getTotalProductAdded = Dealer::where('user_id',$currentuserid)->count();
            
            return $getTotalProductAdded;

        }

    }

    /**
     * Show Dealers Orders
     */
    public function show()
    {
        $currentuserid = Auth::user()->id;
        $allOrderList = Order::where('user_id','=',$currentuserid)->orderByDesc('order_id')->get();

        return view('dealerorder.orderview',  ['allOrderList' => $allOrderList]);
    }

    /**
     * Display All Sub Dealers Orders
     */

    public function showdealerorder()
    {
        $currentuserid = Auth::user()->id;
        $allOrderList = SubOrder::where('dealer_id','=',$currentuserid)->orderByDesc('order_id')->get();

        return view('dealerorder.subdealerorderview',  ['allOrderList' => $allOrderList]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ordershow(string $id)
    {
        $order_id = strip_tags($id);
        $orderDetails = Order::orderDetails($order_id);
        $allorderProductList = OrderList::productList($order_id);

        return view('dealerorder.vieworder',  ['orderDetails' => $orderDetails, 'allorderProductList' => $allorderProductList]); 
    }

    public function subdealerordershow(string $id)
    {
        $order_id = strip_tags($id);
        $orderDetails = SubOrder::orderDetails($order_id);
        $allorderProductList = SubOrderList::productList($order_id);

        return view('dealerorder.subdealervieworder',  ['orderDetails' => $orderDetails, 'allorderProductList' => $allorderProductList]); 
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

    /**
     * Update Sub Dealer Order Status
     */

     public function subdealerorderacceptedstatus(string $id) 
     {
        $updateData = SubOrder::findOrFail($id);
        $updateData->order_status = "accepted";
        $updateData->order_remarks = "Order has been accepted.";
        $updateData->save();
        /**
         * Sending Mail to Dealer and Shamsnatural
         */
        $orderDetails = SubOrder::select('order_id','order_status','dealer_id','user_id','order_remarks')->where('id',$id)->first();
        
        $dealerId = $orderDetails->dealer_id;
        $subDealerId =  $orderDetails->user_id;

        $subDealerEmail = User::select('name','email')->where('id',$subDealerId)->first();
        $mailData = [
            'order_id' => $orderDetails->order_id,
            'order_status' => $orderDetails->order_status,
            'order_remarks' => $orderDetails->order_remarks,
            'dealer_name' => $subDealerEmail->name,
            'delivery_type' => '',
            'courier_company' => '',
            'awb_number' => '',
            'third_party_details' => '',
            'deliver_bill_upload' => '',
        ];
        $mail_to = explode(',', env('MAIL_TO'));
        $dealer_email_to = $subDealerEmail->email;

        Mail::to($mail_to)->send(new OrderStatusMail($mailData));
        Mail::to($dealer_email_to)->send(new OrderStatusMail($mailData));

        return redirect()->route('dealerorder.showdealerorder')->with('success', 'Order status changed successfully.');
     }

     public function subdealerordercancelstatus(string $id) 
     {
        $updateData = SubOrder::findOrFail($id);
        $updateData->order_status = "cancelled";
        $updateData->order_remarks = "Order has been cancelled.";
        $updateData->save();

        /**
         * Sending Mail to Dealer and Shamsnatural
         */
        $orderDetails = SubOrder::select('order_id','order_status','dealer_id','user_id','order_remarks')->where('id',$id)->first();
        
        $dealerId = $orderDetails->dealer_id;
        $subDealerId =  $orderDetails->user_id;

        $subDealerEmail = User::select('name','email')->where('id',$subDealerId)->first();
        $mailData = [
            'order_id' => $orderDetails->order_id,
            'order_status' => $orderDetails->order_status,
            'order_remarks' => $orderDetails->order_remarks,
            'dealer_name' => $subDealerEmail->name,
            'delivery_type' => '',
            'courier_company' => '',
            'awb_number' => '',
            'third_party_details' => '',
            'deliver_bill_upload' => '',
        ];
        $mail_to = explode(',', env('MAIL_TO'));
        $dealer_email_to = $subDealerEmail->email;

        Mail::to($mail_to)->send(new OrderStatusMail($mailData));
        Mail::to($dealer_email_to)->send(new OrderStatusMail($mailData));

        return redirect()->route('dealerorder.showdealerorder')->with('success', 'Order status changed successfully.');
     }

     public function subdealerplaceorder(String $orderid)
     {
        $selectOrderList = SubOrderList::join('products', 'sub_orders_list.product_code', '=', 'products.product_code')
                                        ->select('products.id as prdId', 'sub_orders_list.order_quantity as orderQty')
                                        ->where('sub_orders_list.order_id', '=', $orderid)
                                        ->get();
        $dataToInsert = [];    
        $currentuserid = Auth::user()->id;                            
        foreach ($selectOrderList as $orderList)
        {
            $dataToInsert[] = [
                'user_id' => $currentuserid,
                'product_id' => $orderList->prdId,
                'order_quantity' => $orderList->orderQty,
            ];
        }

        $dataInsert =  Dealer::insert($dataToInsert);
        if ($dataInsert)
        {
            $recordFound = SubOrder::where('order_id', $orderid)->first();
    
            if ($recordFound) {
                $recordFound->update([
                    'order_placed' => 'Yes',
                ]);

    
                return redirect()->route('dealerorder.index')->with('success', 'You can place order from here.');
            } else {
                return redirect()->route('dealerorder.subdealerordershow',$orderid)->with('error', 'Order Not Found. Please try again.');
            }

        }
     }

}