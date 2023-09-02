<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use DB;
use App\Models\User;
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

    public function newpasswordpage() {
        return view('auth.newpassword');
    }


    public function storenewpassword(Request $request) {
        $credentials = $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);


        $hasdedPassword = Hash::make($request->password);
        $userId = Auth::user()->id;
        $updateData = User::findOrFail($userId);
        $updateData->new_user = 'olduser';
        $updateData->password = $hasdedPassword;
        $updateData->save();

        $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('Password has been updated.');
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
