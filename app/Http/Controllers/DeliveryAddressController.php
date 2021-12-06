<?php

namespace App\Http\Controllers;

use App\Models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DeliveryAddress::where('user_id', Auth::user()->id)->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectnew(Request $request)
    {
        // 
        $request->validate([
            'deliveryAddressId' => 'required|numeric',
            'previousDeliveryAddressId' => 'required|numeric',
        ]);

        if(Auth::check()){
            $user_id = Auth::user()->id;

            $previous = DeliveryAddress::where('user_id', $user_id)->get();

            if($previous){
                // set all previous delivery address selected to null;
                DeliveryAddress::where('user_id', $user_id)                    
                    ->update(['selected'=>null]);                

                DeliveryAddress::where('user_id', $user_id)
                    ->where('id', $request->deliveryAddressId)
                    ->update(['selected'=>1]);
                return response('success', 200);
            }
            return response('Failed', 500);

        }
        return response('Unauthorized action', 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DeliveryAddress::where('user_id', Auth::user()->id)
        ->update(['selected'=> 0]);

        $request->validate([
            'city' => 'required|string',
            'state' => 'required|string',
            'street' => 'required|string',
            'apt' => 'string|nullable',
            'postal' => 'nullable|string',
            'phone' => 'string||nullable',
            'country' => 'string|nullable',                 
        ]);

        $adr = new DeliveryAddress();
        $adr->user_id = Auth::user()->id;
        $adr->city = $request->city;
        $adr->state = $request->state;
        $adr->street = $request->street;
        $adr->country = $request->country;
        $adr->apt = $request->apt;
        $adr->postal = $request->postal;
        $adr->name = $request->name;
        $adr->contact = $request->phone;
        $adr->selected = 1;
        $adr->save();

        return $adr;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryAddress $deliveryAddress)
    {
        //
    }
}
