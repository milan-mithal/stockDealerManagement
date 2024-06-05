<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Validation\Rules\Enum;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\SubOrder;
use App\Models\SubOrderList;
use App\Enums\OrderStatusEnums;
use Auth;
use Mail;
use File;
use App\Models\User;
use App\Mail\Order\OrderStatusMail;



class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
        $this->middleware('checkpackingrole');
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
            //'courier_company' => 'required_if:order_status,delivery',
            //'awb_number' => 'required_if:order_status,delivery',
            //'deliver_bill_upload' => 'required_if:order_status,delivery|mimes:jpeg,png,jpg,pdf|max:2048',
            'deliver_bill_upload' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'order_remarks' => 'required',
        ], [
            'order_status.required' => 'Please choose order status.',
            //'courier_company.required_if' => 'Please enter couries/delivery company name.',
            //'awb_number.required_if' => 'Please enter AWB number.',
            //'deliver_bill_upload.required_if' => 'Please select an image/pdf file to upload.',
            'deliver_bill_upload.image' => 'The uploaded file must be an image/pdf.',
            'deliver_bill_upload.mimes' => 'Only jpeg, png, jpg, and pdf files are allowed.',
            'deliver_bill_upload.max' => 'The uploaded image must not exceed 2MB.',
            'order_remarks.required' => 'Please enter order remarks.',
        ]);

        $getOrderDetails = Order::where('id', '=' ,$id)->first();
        $userId = $getOrderDetails->user_id;
        $order_id = $getOrderDetails->order_id;
        $userDetails = User::where('id', '=', $userId)->first();
        $userDealerName = $userDetails->dealer_name;
        $userEmail = $userDetails->email;
        
        $billUploadFilePath = '';
        if ($request->hasFile('deliver_bill_upload')) {
            $path = '/uploads/delivery_receipts/';
            $billUploadFile = time().'.'.$request->deliver_bill_upload->extension();
            $request->deliver_bill_upload->move(public_path($path), $billUploadFile);
            $billUploadFilePath = $path.$billUploadFile;
        }
        
        $updateData = Order::findOrFail($id);
        $updateData->order_status = $request->order_status;

        if($request->order_status == 'cancelled') {
           OrderList::cancelledOrderQtyAddedBack($order_id);
        }

        
        $updateData->order_remarks = $request->order_remarks;
        if($request->delivery_type == 'delivery') {
            $updateData->courier_company = $request->courier_company;
            $updateData->awb_number = $request->awb_number;
            $updateData->deliver_bill_upload = $billUploadFilePath;
        }
        $updateData->modified_by = Auth::user()->id;
        $updateData->save();
        
        $delivery_type = $request->delivery_type;
        $courier_company = '';
        $awb_number = '';
        $third_party_details = '';

        if($request->delivery_type == 'delivery') {
            $courier_company = $request->courier_company;
            $awb_number = $request->awb_number;
        }

        if($request->delivery_type == 'third_party') {
            $third_party_details = $request->third_party_details;
        }



        $mailData = [
            'order_id' => $order_id,
            'dealer_name' => $userDealerName,
            'order_remarks' => $request->order_remarks,
            'order_status' => $request->order_status,
            'delivery_type' => $delivery_type,
            'courier_company' => $courier_company,
            'awb_number' => $awb_number,
            'third_party_details' => $third_party_details,
            'deliver_bill_upload' => $billUploadFilePath

        ];

        Mail::to($userEmail)->send(new OrderStatusMail($mailData));

        return redirect()->route('order.index')->with('success', 'Order Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function suborderindex()
    {
        $allOrderList = SubOrder::allOrderDetails();

        return view('order.suborderview',  ['allOrderList' => $allOrderList]); 
    }

  
    
    /**
     * Display the specified resource.
     */
    public function subordershow(string $id)
    {
        $order_id = strip_tags($id);
        $orderDetails = SubOrder::orderDetails($order_id);
        $allorderProductList = SubOrderList::where('order_id', '=' , $order_id)->get();

        return view('order.subordervieworder',  ['orderDetails' => $orderDetails, 'allorderProductList' => $allorderProductList]); 

    }
}