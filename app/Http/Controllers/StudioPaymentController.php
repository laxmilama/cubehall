<?php

namespace App\Http\Controllers;

use App\Models\StudioPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->pages) {
            return StudioPayment::where('page_id', Auth::user()->pages[0]->id)
                ->latest()
                ->take(10)
                ->get();
        }
        return response('Unauthenticated', 403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'string|required|max:16',
            'bank_name' => 'string|required|max:50',
            'address' => 'numeric|required',
            'name' => 'required|string'
        ]);

        $pmtC = StudioPayment::where('page_id', Auth::user()->pages[0]->id)->get()->count();
        if ($pmtC >= 20) {
            return response('Number Exceeded', 417);
        }
        if ($request->type == 'Khalti') {
            if (StudioPayment::where('type', 'Khalti')
                ->where('address', $request->address)
                ->exists()
            ) {
                return response('Payment method already exists', 429);
            }
        }
        if ($request->type == "Bank") {
            if (StudioPayment::where('type', 'Bank')->where('address', $request->address)->exists()) {
                return response('Payment method already exists', 429);
            }
        }

        $payment = new StudioPayment();
        $payment->page_id = Auth::user()->pages[0]->id;
        $payment->type = $request->type;
        $payment->address = $request->address;
        $payment->bank_name = $request->bank_name;
        $payment->customer_name = $request->name;
        $payment->save();

        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudioPayment  $studioPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudioPayment $studioPayment)
    {
        if (Auth::user()->pages[0]->id == $studioPayment->page_id) {
            $studioPayment->delete();
            return response('success', 200);
        } else {
            return response('Failed', 403);
        }
    }
}
