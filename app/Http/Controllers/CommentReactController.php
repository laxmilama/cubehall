<?php

namespace App\Http\Controllers;

use App\Models\CommentReact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentReactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'commentId' => 'required|numeric',
        ]);

        if(CommentReact::where('user_id', Auth::user()->id)->where('comment_id', $request->commentId)->exists()){
            return response("Exists");
        }
        $react = new CommentReact;
        $react->user_id = Auth::user()->id;
        $react->comment_id = $request->commentId;
        $react->save();
        return response('OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommentReact  $commentReact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('comment_reacts')->where('user_id', Auth::user()->id)->where('comment_id', $id)->delete();
        return 'ok';
    }
}
