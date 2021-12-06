<?php

namespace App\Http\Controllers;

use App\Models\StudioAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            if (count(Auth::user()->pages) > 0) {
                return StudioAddress::where('page_id', Auth::user()->pages[0]->id)->paginate(10);
            } else {
                return response('Unauthenticated', 401);
            }
        } else {
            return response('Unauthenticated', 401);
        }
    }

    public function store($request, $parent_id)
    {
        $request->validate([
            'country' => 'string|required|max:16',
            'city' => 'string|required',
            'street' => 'required|string',
            'postal' => 'numeric|nullable',
            'state' => 'required'
        ]);
        // return $request->country;
        $location = json_decode($request, true);
        $address = new StudioAddress();
        $address->country = $location['country'];
        $address->state = $location['state'];
        $address->city = $location['city'];
        $address->street = $location['street'];
        $address->apt = $location['apt'];
        $address->postal = $location['postal'];
        $address->parent_id = $parent_id;
        $address->save();
        return $address;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudioAddress  $studioAddress
     * @return \Illuminate\Http\Response
     */
    public function update(StudioAddress $studioAddress, Request $request)
    {
        $request->validate([
            'country' => 'string|required|max:16',
            'city' => 'string|required',
            'street' => 'required|string',
            'postal' => 'numeric|nullable',
            'state' => 'required'
        ]);

        if ($studioAddress->page_id != Auth::user()->pages[0]->id) {
            return response("Unauthenticated", 403);
        }

        if ($studioAddress) {
            if ($request->apt != 'null') {
                $apt = $request->apt;
            } else {
                $apt = null;
            }

            if ($request->postal != 'null') {
                $postal = $request->postal;
            } else {
                $postal = null;
            }
            StudioAddress::where('id', $studioAddress->id)
                ->update([
                    'country' => $request->country,
                    'city' => $request->city,
                    'street' => $request->street,
                    'postal' => $postal,
                    'apt' => $apt,
                    'state' => $request->state
                ]);
        }
        return response('Success', 200);
    }

    public function updateMobile(StudioAddress $studioAddress, Request $request)
    {
        $request->validate([
            'number'=> 'string|required'
        ]);

        if ($studioAddress->page_id != Auth::user()->pages[0]->id) {
            return response("Unauthenticated", 403);
        }

        StudioAddress::where('page_id', Auth::user()->pages[0]->id)
            ->update(['contact'=> $request->number]);
        return response('success', 200);
    }
}
