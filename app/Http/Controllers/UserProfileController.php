<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Parlor;
use App\Models\ProductList;
use App\Models\Save;
use App\Models\ShowOff;
use App\Models\Story;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageController;
use App\Http\Resources\UserProfileResources;

class UserProfileController extends Controller
{
    protected $ImageController;

    public function __construct(ImageController $imageController){
        $this->ImageController = $imageController;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function show(User $userProfile)
    {
        // return $userProfile;
        
        // return User::with('studio')->get();
        $user =  new UserProfileResources(User::findOrFail($userProfile->id));

        $showoffs = ShowOff::where('user_id', $userProfile->id)->latest('id')->take(10)->get();

        $boards = Save::where('user_id', $userProfile->id)->latest('id')->take(10)->get();

        // return $showoffs;
        return view('profile.view', [
            'user' => $userProfile,
            'showoffs' => $showoffs,
            'boards' => $boards,
        ]);
    }

    public function board(User $userProfile)
    {

        if (Auth::check()) {
            if (Auth::user()->id == $userProfile->id) {
                $boards = Board::where('user_id', $userProfile->id)->latest('id')->get();
            } else {
                $boards = Board::where('user_id', $userProfile->id)->where('private', 'false')->latest('id')->get();
            }
        } else {
            $boards = Board::where('user_id', $userProfile->id)->where('private', 'false')->latest('id')->get();
        }

        // return $boards;

        return view('profile.board', [
            'user' => $userProfile,
            'boards' => $boards,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
            'userId' => 'required|numeric',
        ]);

        if ($request->userId == Auth::user()->id) {

            $filename = $this->ImageController->store($request->image->path(), true, 'profile');

            $profile = new UserProfile;
            $profile->image = $filename;
            $profile->user_id = $request->userId;
            $profile->save();

            return response()->json(['image' => $filename]);
        }
        abort(401);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProfile $userProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
