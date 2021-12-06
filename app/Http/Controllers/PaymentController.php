<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'address' => 'numeric|required'
        ]);

        $pmtC = Payment::where('user_id', Auth::user()->id)->get()->count();
        if($pmtC >= 20){
            return response('Number Exceeded', 417);
        }

        if ($request->type == 'Khalti') {
            if (Payment::where('type', 'Khalti')
                ->where('address', $request->address)
                ->exists()
            ) {
                return response('Payment method already exists', 429);
            }
        }
        if($request->type == "Bank"){
            if(Payment::where('type', 'Bank')->where('address', $request->address)->exists())
            {
                return response('Payment method already exists', 429);
            }
        }

        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        $payment->type = $request->type;
        $payment->address = $request->address;
        $payment->bank_name = $request->bank_name;
        $payment->save();

        return $payment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $payments = Payment::where('user_id', Auth::user()->id)->get();

        return view('settings.user.payment', [
            'payments' => json_encode($payments),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        if ($payment->user_id == Auth::user()->id) {
            $payment->delete();

            return response('ok', 200);
        } else {
            return response('failed', 403);
        }
    }
}
