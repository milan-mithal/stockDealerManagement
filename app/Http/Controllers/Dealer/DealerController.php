<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\Product;
use App\Enums\DeleteStatusEnums;
use Illuminate\Validation\Rules\Enum;
use Auth;

class DealerController extends Controller
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
        $productListNatural = Dealer::productListNatural();
        $productListEssentials = Dealer::productListEssentials();
        return view('dealer.view',  ['productListNatural' => $productListNatural, 'productListEssentials' => $productListEssentials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = Auth::user()->id;
        $orderQty = $request->quantity;
        Dealer::where('user_id', $user_id)->delete();
        $productList = Product::where('status', '!=', DeleteStatusEnums::Deleted)->get();
        foreach($productList as $product) {
            $product_id = $product->id;
            $checkActualQty = Product::leftJoin('stocks', 'products.product_code', '=' , 'stocks.product_code')
                          ->select('stocks.stock_qty', 'stocks.stock_coming_soon')
                          ->where('products.id', '=', $product_id)->first();
                if ($checkActualQty && ($orderQty <= $checkActualQty->stock_qty) || ($orderQty <= $checkActualQty->stock_coming_soon)) {
                    $insertData = new Dealer();
                    $insertData->user_id = $user_id;
                    $insertData->product_id = $product_id;
                    $insertData->order_quantity = $orderQty;
                    $insertData->save();
                }
        }
        return redirect()->route('dealerorder.index')->with('success', 'Products Added successfully.');
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