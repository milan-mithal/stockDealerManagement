<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Mail;
use DB;
use App\Enums\UserStatusEnums;
use App\Enums\UserRolesEnums;
use App\Mail\User\ForgotPasswordMail;
use App\Models\Dealer;
use App\Models\User;
use App\Models\Order;
use App\Models\SubOrder;
use App\Models\Product;
use App\Models\Stock;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('checknewuser');
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a forgotpassword form.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotpassword()
    {
        return view('auth.forgotpassword');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotpasswordauthenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:250|exists:users',
        ], [
            
            'email.required' => 'Please enter email id.',
            'email.email' => 'Please enter valid email id.',
            'email.max' => 'Maximum 250 characters allowed.',
            'email.exists' => 'Invalid email id'
        ]);

        $emailId = $request->email;
        $password = Str::password(10);
        $hasdedPassword = Hash::make($password);

        $getDetails = User::where('email',$emailId)->first();
        if ($getDetails) {
            $userId = $getDetails->id;
    
            $updateData = User::findOrFail($userId);
            $updateData->new_user = 'forgotpass';
            $updateData->password = $hasdedPassword;
            $updateData->save();
    
            $mailData = [
                'name' => $getDetails->name,
                'useremail' => $getDetails->email,
                'password' => $password
            ];
    
    
             
            Mail::to($request->email)->send(new ForgotPasswordMail($mailData));
            return redirect()->route('login')->with('success', 'Password updated successfully. Kindly check your email & login here.');
        }

        return redirect()->route('forgotpassword')->with('error', 'Some error occured.');


    } 

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials))
        {
                $request->session()->regenerate();
                return redirect()->route('dashboard')
                    ->withSuccess('You have successfully logged in!');
        }

        

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    } 
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::check() && Auth::user()->role == 'admin')
        {
            $totalDealers = 0;
            $totalDealers = User::where([['role','dealer'],['status', '=', 'active']])->count();
            $totalSubDealers = 0;
            $totalSubDealers = User::where([['role','subdealer'],['status', '=', 'active']])->count();

            $totalOrders = 0;
            $totalOrders = Order::where('order_status','!=','cancelled')->count();

            $totalProducts = 0;
            $totalProducts = Product::where('status','!=','deleted')->count();

            $totalDealerAddedCurrentMonth = 0;
            $totalDealerAddedCurrentMonth = User::where([['role','dealer'],['status', '=', 'active']])
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();
            
            $totalSubDealerAddedCurrentMonth = 0;
            $totalSubDealerAddedCurrentMonth = User::where([['role','subdealer'],['status', '=', 'active']])
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

            $totalOrderAddedCurrentMonth = 0;
            $totalOrderAddedCurrentMonth = Order::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->where('order_status','!=','cancelled')
                ->count();
            
            $totalAmountOrder = 0;
            $totalAmountOrder = Order::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount');

            $allOutOfStockProducts = [];
            $allOutOfStockProducts = Stock::select('product_code','stock_qty')
            ->whereColumn('stock_qty', '<=', 'stock_min_qty')
            ->get();

            $allOrderList = [];
            $allOrderList = Order::recentOrders();

            $totalStockAmount = Stock::join('products', 'stocks.product_code', '=', 'products.product_code')
                                ->where('products.status', '!=', 'deleted')
                                ->selectRaw('SUM(stocks.stock_qty) as total_stock_qty, SUM(stocks.stock_qty * products.product_price) as total_stock_price')
                                ->first();
            

            return view('dashboard.admin',[
                'totalDealers' => $totalDealers,
                'totalSubDealers' => $totalSubDealers,
                'totalOrders' => $totalOrders,
                'totalProducts' => $totalProducts,
                'totalDealerAddedCurrentMonth' => $totalDealerAddedCurrentMonth,
                'totalSubDealerAddedCurrentMonth' => $totalSubDealerAddedCurrentMonth,
                'totalOrderAddedCurrentMonth' => $totalOrderAddedCurrentMonth,
                'totalAmountOrder' => $totalAmountOrder,
                'allOutOfStockProducts' => $allOutOfStockProducts,
                'allOrderList' => $allOrderList,
                'totalStockAmount' => $totalStockAmount
            ]);
        }  
        if(Auth::check() && Auth::user()->role == 'dealer') {
            $currentuserid = Auth::user()->id;
            $allOrderList = Order::where('user_id','=',$currentuserid)->orderByDesc('order_id')->get();
            $allSubOrderList = SubOrder::where('dealer_id','=',$currentuserid)->orderByDesc('order_id')->get();
            $totalProducts = 0;
            $totalProducts = Product::where('status','!=','deleted')->count();

            $totalStockAmount = Stock::join('products', 'stocks.product_code', '=', 'products.product_code')
                                ->where('products.status', '!=', 'deleted')
                                ->selectRaw('SUM(stocks.stock_qty) as total_stock_qty, SUM(stocks.stock_qty * products.product_price) as total_stock_price')
                                ->first();

            return view('dashboard.dealer',[
                'allOrderList' => $allOrderList,
                'allSubOrderList' => $allSubOrderList,
                'totalProducts' => $totalProducts,
                'totalStockAmount' => $totalStockAmount
            ]);
        }

        if(Auth::check() && Auth::user()->role == 'subdealer') {
            $currentuserid = Auth::user()->id;
            $allOrderList = SubOrder::where('user_id','=',$currentuserid)->orderByDesc('order_id')->get();
            $totalProducts = 0;
            $totalProducts = Product::where('status','!=','deleted')->count();

            $totalStockAmount = Stock::join('products', 'stocks.product_code', '=', 'products.product_code')
                                ->where('products.status', '!=', 'deleted')
                                ->selectRaw('SUM(stocks.stock_qty) as total_stock_qty, SUM(stocks.stock_qty * products.product_price) as total_stock_price')
                                ->first();

            return view('dashboard.subdealer',[
                'allOrderList' => $allOrderList,
                'totalProducts' => $totalProducts,
                'totalStockAmount' => $totalStockAmount
            ]);
        }

        if(Auth::check() && Auth::user()->role == 'packing')
        {


            $totalOrders = 0;
            $totalOrders = Order::all()->count();

            $totalProducts = 0;
            $totalProducts = Product::all()->count();


            $totalOrderAddedCurrentMonth = 0;
            $totalOrderAddedCurrentMonth = Order::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();
            

            $allOutOfStockProducts = [];
            $allOutOfStockProducts = Stock::select('product_code','stock_qty')
            ->whereColumn('stock_qty', '<=', 'stock_min_qty')
            ->get();

            $allOrderList = [];
            $allOrderList = Order::recentOrders();

            return view('dashboard.packing',[
                'totalOrders' => $totalOrders,
                'totalProducts' => $totalProducts,
                'totalOrderAddedCurrentMonth' => $totalOrderAddedCurrentMonth,
                'allOutOfStockProducts' => $allOutOfStockProducts,
                'allOrderList' => $allOrderList
        ]);
        }  
        
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }

    


}
