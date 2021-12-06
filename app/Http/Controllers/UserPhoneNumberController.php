<?php

namespace App\Http\Controllers;

use App\Models\UserPhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPhoneNumberController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->userId == Auth::user()->id) {

            $number = new UserPhoneNumber();
            $number->user_id = Auth::user()->id;
            $number->number = $request->number;
            
        }
        return "Sorry";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPhoneNumber  $userPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPhoneNumber $userPhoneNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPhoneNumber  $userPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPhoneNumber $userPhoneNumber)
    {
        //
    }
}
