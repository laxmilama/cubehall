<?php

namespace App\Http\Controllers;
use App\Models\Reaction;
use Illuminate\Http\Request;
use App\Models\ShowOffReaction;
use App\Notifications\ShowOfReactNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowOffReactionController extends Controller
{
 
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'showoffId' => 'required|numeric',
            'reaction' => 'required|numeric',
        ]);

        if(ShowOffReaction::where('user_id', Auth::user()->id)->where('showoff_id', $request->storyId)->exists()){
            return response("Exists");
        }
        $reaction = new ShowOffReaction;
        $reaction->user_id = Auth::user()->id;
        $reaction->showoff_id = $request->showoffId;
        $reaction->reaction = $request->reaction;
        $reaction->save();

        $reaction->showoff->owner;
        if(Auth::user()->id != $reaction->showoff->owner->id){
            $reaction->showoff->owner->notify(new ShowOfReactNotification($reaction));
        }
        return response('OK');
    }

    public function destroy(Request $request)
    {   
        $request->validate([
            'showoffId' => 'required|numeric',
        ]);

        DB::table('show_off_reactions')->where('user_id', Auth::user()->id)->where('showoff_id', $request->showoffId)->delete();
        return 'ok';
    }

}
