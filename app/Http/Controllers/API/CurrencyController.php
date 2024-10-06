<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => "https://api.apilayer.com/currency_data/list",
        // CURLOPT_HTTPHEADER => array(
        //     "Content-Type: text/plain",
        //     "apikey: ".env('CURRENCY_API')
        // ),
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "GET"
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        
        // $data = json_decode($response, true);

        // // Check if JSON decoding was successful and the "currencies" key exists
        // if ($data && isset($data['currencies'])) {
        //     // Extract the currencies
        //     $currencies = $data['currencies'];
            
        //     // Loop through the currencies and do something with them
        //     foreach ($currencies as $currencyCode => $currencyName) {
        //         $insertData = new Currency();
        //         $insertData->country = $currencyName;
        //         $insertData->country_currency = $currencyCode;
        //         $insertData->currency = '';
        //         $insertData->rate = '0.00';
        //         $insertData->save();
        //     }
        // } else {
        //     echo "Invalid JSON data or missing 'currencies' key.";
        // }

        $curl2 = curl_init();

        curl_setopt_array($curl2, array(
        CURLOPT_URL => "https://api.apilayer.com/currency_data/live?source=AED&currencies=currencies",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: ".env('CURRENCY_API')
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response2 = curl_exec($curl2);

        curl_close($curl2);
        $data2 = json_decode($response2, true);

        // Check if JSON decoding was successful and the "currencies" key exists
        if ($data2 && isset($data2['quotes'])) {
            // Extract the currencies
            $quotes = $data2['quotes'];
            
            // Loop through the currencies and do something with them
            foreach ($quotes as $currencyCode => $rate) {
                $getId = Currency::where('currency','=',$currencyCode)->first();
                $updateData = Currency::findOrFail($getId->id);
                $updateData->rate = $rate;
                $updateData->save();
            }
        } else {
            echo "Invalid JSON data or missing 'currencies' key.";
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