<?php

namespace App\Http\Controllers;

use App\Models\KYC;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\SuperAdmin;
use App\Notifications\KYCNotification;
use Illuminate\Support\Facades\Auth;

class KYCController extends Controller
{
    protected $ImageController;

    public function __construct(ImageController $imageController)
    {
        $this->ImageController = $imageController;
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
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:20048',
        ]);

        $filename = $this->ImageController->store($request->image->path(), false, 'kyc');

        return response()->json(['image' => $filename]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'country' => 'required',
                'front' => 'required|min:10',
                'back' => 'nullable',
                'profile' => 'required|min:10',
                'type' => 'required|min:6',
            ]);

            $kyc = new KYC();
            $kyc->user_id = Auth::user()->id;
            $kyc->country = $request->country;
            $kyc->front = $request->front;
            $kyc->back = $request->back;
            $kyc->person = $request->profile;
            $kyc->type = $request->type;
            $kyc->verified = 0;

            $kyc->save();

            $admins = SuperAdmin::get();
            // return $admins;
           
                 foreach ($admins as $admin) {
                     // return $followtoss;
                     
                     $admin->notify(new KYCNotification($kyc,Auth::user() ));
                     }

            return response()->json(['success' => 201]);
        } else {
            return response()->json(['error' => 400]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KYC  $kYC
     * @return \Illuminate\Http\Response
     */
    public function show(KYC $kYC)
    {
        return $kYC;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KYC  $kYC
     * @return \Illuminate\Http\Response
     */
    public function edit(KYC $kYC)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KYC  $kYC
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KYC $kYC)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KYC  $kYC
     * @return \Illuminate\Http\Response
     */
    public function destroy(KYC $kYC)
    {
        //
    }
}
