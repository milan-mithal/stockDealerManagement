<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MainDealerPercentage;
use App\Models\Currency;

class CommonHelper
{
    public static function calculatePrice($price)
    {
       // Check if the session values are already set
    if (!Session::has('percentage') || !Session::has('inc_dec')) {
        // If not set, fetch from database and set in session
        $userId = Auth::user()->id;
        $currency = Auth::user()->currency;
        $getDetails = MainDealerPercentage::where('dealer_id', $userId)->first();
        $getRate = Currency::where('country_currency','=',$currency)->first();
        $rate = $getRate->rate;
        $percentage = optional($getDetails)->percentage ?? 0;
        $incDec = optional($getDetails)->inc_dec ?? '+';

        // Save percentage and incDec to session
        Session::put('percentage', $percentage);
        Session::put('inc_dec', $incDec);
        Session::put('currency', $currency);
        Session::put('rate', $rate);
    } else {
        // If session is already set, fetch from session
        $percentage = Session::get('percentage');
        $incDec = Session::get('inc_dec');
        $currency = Session::get('currency');
        $rate = Session::get('rate');
    }
    
    
    // Calculate the product price based on the percentage and incDec
    if ($incDec == '+') {
        $productPercentagePrice = ($price * $percentage) / 100 + $price;
    } elseif ($incDec == '-') {
        $productPercentagePrice = $price - ($price * $percentage) / 100;
    }

    if($currency != 'AED') {
        $finalPrice = $productPercentagePrice * $rate;
    } else {
        $finalPrice = $productPercentagePrice;
    }

    // Return the calculated price, rounded to 2 decimal places
    return round($finalPrice, 2);
    }
}