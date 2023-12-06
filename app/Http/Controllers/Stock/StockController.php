<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use Auth;

class StockController extends Controller
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
        $stockList = Stock::productList();
        return view('stock.view',  ['allStockList' => $stockList]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stock.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|exists:products,product_code|unique:stocks,product_code',
            'stock_qty' => 'required|numeric',
            'stock_sold_qty' => 'required|min:0|numeric',
            'stock_min_qty' => 'required|min:1|numeric',
            'stock_coming_soon' => 'required|min:0|numeric',
        ], [
            'product_code.required' => 'Please enter product code.',
            'product_code.exists' => 'Product code does not exists.',
            'product_code.unique' => 'Stock for this product code already exists.',
            'stock_qty.required' => 'Please enter stock quantity.',
            'stock_qty.numeric' => 'Stock quantity should be numeric.',
            'stock_sold_qty.required' => 'Please enter stock sold quantity.',
            'stock_sold_qty.min' => 'Stock sold quantity cannot be less than 0.',
            'stock_sold_qty.numeric' => 'Stock sold quantity should be numeric.',
            'stock_min_qty.required' => 'Please enter stock Minimum quantity alert.',
            'stock_min_qty.min' => 'Stock Minimum quantity cannot be less than 1.',
            'stock_min_qty.numeric' => 'Stock Minimum quantity should be numeric.',
            'stock_coming_soon.required' => 'Please enter coming soon quantity.',
            'stock_coming_soon.min' => 'Coming Soon quantity cannot be less than 0.',
            'stock_coming_soon.numeric' => 'Coming Soon quantity should be numeric.',
        ]);
        
        // Insert data into the database
        $insertData = new Stock();
        $insertData->product_code = $request->product_code;
        $insertData->coming_soon = $request->coming_soon;
        $insertData->stock_qty = $request->stock_qty;
        $insertData->stock_sold_qty = $request->stock_sold_qty;
        $insertData->stock_min_qty = $request->stock_min_qty;
        $insertData->stock_coming_soon = $request->stock_coming_soon;
        $insertData->created_by = Auth::user()->id;
        $insertData->modified_by = Auth::user()->id;
        $insertData->save();
    
        return redirect()->route('stock.create')->with('success', 'Stock added successfully.');
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
        $stockDetail = Stock::findOrFail($id);
        return view('stock.edit', compact('stockDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stock_qty' => 'required|numeric',
            'stock_min_qty' => 'required|min:1|numeric',   
        ], [
            'stock_qty.required' => 'Please enter stock quantity.',
            'stock_qty.numeric' => 'Stock quantity should be numeric.',
            'stock_min_qty.required' => 'Please enter stock Minimum quantity alert.',
            'stock_min_qty.min' => 'Stock Minimum quantity cannot be less than 1.',
            'stock_min_qty.numeric' => 'Stock Minimum quantity should be numeric.',
        ]);
        
        // Insert data into the database
        $updateData = Stock::findOrFail($id);
        $updateData->coming_soon = $request->coming_soon;
        $updateData->stock_qty = $request->stock_qty;
        $updateData->stock_min_qty = $request->stock_min_qty;
        $updateData->stock_coming_soon = $request->stock_coming_soon;
        $updateData->modified_by = Auth::user()->id;;
        $updateData->save();
    
        return redirect()->route('stock.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}