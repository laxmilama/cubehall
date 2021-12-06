<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request, $day)
    {
        $addresses = json_decode($request, true);    
        for ($i = 0; $i < count($addresses); $i++) {

        }
        
    }

}
