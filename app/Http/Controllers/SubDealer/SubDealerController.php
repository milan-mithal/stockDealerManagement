<?php

namespace App\Http\Controllers\SubDealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubDealer;
use App\Models\Currency;
use App\Models\DealerPercentage;
use Auth;


class SubDealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checknewuser');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $productList = SubDealer::productList();
        $currentuserid = Auth::user()->id;
        $currentuserDealerId = Auth::user()->dealer_id;
        $currentuserCurrency = Auth::user()->currency;
        $getRate = Currency::where('country_currency','=',$currentuserCurrency)->first();
        $rate = $getRate->rate;
        $getPercentage = DealerPercentage::where([['dealer_id','=',$currentuserDealerId],['sub_dealer_id','=',$currentuserid]])->first();
        $dealerPercentage = $getPercentage->percentage;
        return view('subdealer.view',  ['allProductList' => $productList,'rate'=> $rate,'userCurrency' => $currentuserCurrency, 'dealerPercentage' => $dealerPercentage]);
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
