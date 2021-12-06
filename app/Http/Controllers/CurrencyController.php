<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Currency;
use App\Models\ProductList;
use Cookie;
use Illuminate\Support\Facades\Cache;

class CurrencyController extends Controller
{
  public function saveCurrency(Request $request)
  {

    $data = $request->all();
    $currency = $data['currency'];
    // Cookie::queue(Cookie::forever('currency', $currency));
    return back()->withCookie(cookie()->forever('currency', $currency));
  }

  public function getCurrency()
  {
    return Cache::remember('exchangerates', 60*60*24, function () {
      $req_url = 'https://api.exchangerate.host/latest?base=USD&symbols=NPR,INR,EUR,USD';
      $response_json = file_get_contents($req_url);
      if (false !== $response_json) {
        try {
          $response = json_decode($response_json);
          if ($response->success === true) {
            return $response->rates;
          }
        } catch (Exception $e) {
          // Handle JSON parse error...
        }
      }
    });
  }
}
