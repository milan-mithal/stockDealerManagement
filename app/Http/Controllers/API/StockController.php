<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use Mail;
use App\Mail\Stock\StockMail;

class StockController extends Controller
{
    /**
     * Send Mail for Out of Stock Products
     */
    public function index()
    {
        $allOutOfStockProducts = Stock::select('product_code','stock_qty')
                        ->whereColumn('stock_qty', '<=', 'stock_min_qty')
                        ->get();

        $allOutOfStockProductsCount = $allOutOfStockProducts->count();
        
        if($allOutOfStockProductsCount > 0) {
            $mailData = [
                'allOutOfStockProducts' => $allOutOfStockProducts,
            ];

            $mail_to = explode(',', env('MAIL_TO'));
            
            Mail::to($mail_to)->send(new StockMail($mailData));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
