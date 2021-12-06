<?php

namespace App\Http\Controllers;

use App\Models\FollowUser;
use App\Models\User;
use App\Notifications\FollowUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowUserController extends Controller
{
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
        if(FollowUser::where('followed_by', Auth::user()->id)->where('followed_to', $request->userId)->exists()){
            return response("Exists");
        }

        $follow = new FollowUser;
        $follow->followed_by = Auth::user()->id;
        $follow->followed_to = $request->userId;
        $follow->save();

     
        $follow->followto->notify(new FollowUserNotification($follow->followby,$follow->followto));

        return response('OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FollowUser  $followUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        DB::table('follow_users')->where('followed_by', Auth::user()->id)->where('followed_to', $id)->delete();
        return 'OK';
    }
}
