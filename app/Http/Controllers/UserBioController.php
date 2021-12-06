<?php

namespace App\Http\Controllers;

use App\Models\UserBio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBioController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'bio' => 'required|max:500',
            'userId' => 'required|numeric',
        ]);
        
        if($request->userId != Auth::user()->id){
            return response()->json(['error' => 'Unauthorized action performed', 'code' => '401 ' ]);
        }

        $bio = new UserBio();
        $bio->user_id = $request->userId;
        $bio->bio = $request->bio;
        $bio->save();
        
        return response()->json('ok: 200');
    }
}
