<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Reaction;
use App\Notifications\StoryReactNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reaction::all();
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
            'storyId' => 'required|numeric',
            'reaction' => 'required|numeric',
        ]);

        if(Reaction::where('user_id', Auth::user()->id)->where('story_id', $request->storyId)->exists()){
            return response("Exists");
        }
        $reaction = new Reaction;
        $reaction->user_id = Auth::user()->id;
        $reaction->story_id = $request->storyId;
        $reaction->reaction = $request->reaction;
       $reaction->save();

        $studio=$reaction->story->owner->user;
        //  return $studio;
        foreach($studio as $stu){
            if(Auth::user()->id != $stu->id){
            $stu->notify(new StoryReactNotification($reaction));
       }
    }
        return response('OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reactions  $reactions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        DB::table('reactions')->where('user_id', Auth::user()->id)->where('story_id', $id)->delete();
        return 'ok';
    }
}
