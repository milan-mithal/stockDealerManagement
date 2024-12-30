<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MainDealerPercentage;
use App\Models\Currency;
class CommonHelper
{
    private static function inc_dec_fun($percentage,$incDec,$price) {
        if ($incDec == '+') {
            $productPercentagePrice = ($price * $percentage) / 100 + $price;
        } elseif ($incDec == '-') {
            $productPercentagePrice = $price - ($price * $percentage) / 100;
        }
        return $productPercentagePrice;
    }
    private static function currency_cal($inc_dec_result,$currency,$rate) {
        if($currency != 'AED') {
            $finalPrice = $inc_dec_result * $rate;
        } else {
            $finalPrice = $inc_dec_result;
        }
        return $finalPrice;
    }
    private static function discount_option($discount_option,$prod_cat,$percentage,$incDec,$price,$currency,$prod_disc,$rate) {
        if($discount_option == 1 || ($discount_option == 2 && $prod_cat == 'naturals') || ($discount_option == 3 && $prod_cat == 'essentials')) {
            $inc_dec_result = Self::inc_dec_fun($percentage,$incDec,$price);
            $currency_result = Self::currency_cal($inc_dec_result,$currency,$rate);
            return $currency_result;
        } elseif ($discount_option == 4) {
            $percentage = $prod_disc > 0 ? $prod_disc : 0;
            $inc_dec_result = Self::inc_dec_fun($prod_disc,$incDec,$price);
            $currency_result = Self::currency_cal($inc_dec_result,$currency,$rate);
            return $currency_result;
        } else {
            return $price;
        }
    }
    public static function calculatePrice($price, $prod_disc, $prod_cat)
    {
        $discount_option = 0;
        $percentage = 0;
        $incDec = '+';
        $userId = Auth::user()->id;
        $currency = Auth::user()->currency;
        $rate = 1;
        if (!Session::has('discount_option')) {
            $getRate = Currency::where('country_currency','=',$currency)->first();
            $rate = $getRate->rate;
            $getDetails = MainDealerPercentage::where('dealer_id', $userId)->first();
            if($getDetails) {
                $discount_option = $getDetails->discount_option;
                $percentage = optional($getDetails)->percentage ?? 0;
                $incDec = optional($getDetails)->inc_dec ?? '+';
                $discount_function = Self::discount_option($discount_option,$prod_cat,$percentage,$incDec,$price,$currency,$prod_disc,$rate);
            } else {
                $discount_function = $price;
            }
            Session::put('discount_option', $discount_option);
            Session::put('percentage', $percentage);
            Session::put('inc_dec', $incDec);
            Session::put('currency', $currency);
            Session::put('rate', $rate);
            return round($discount_function, 2);
        } else {
            $percentage = Session::get('percentage');
            $incDec = Session::get('inc_dec');
            $currency = Session::get('currency');
            $rate = Session::get('rate');
            $discount_option = Session::get('discount_option');
            $discount_function = Self::discount_option($discount_option,$prod_cat,$percentage,$incDec,$price,$currency,$prod_disc,$rate);
            return round($discount_function, 2);
        }
    }
}