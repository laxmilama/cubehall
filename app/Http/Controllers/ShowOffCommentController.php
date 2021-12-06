<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ShowOff;
use App\Notifications\ShowoffCommentNotification;
use App\Notifications\ShowoffCommentReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowOffCommentController extends Controller
{
    function index($id)
    {
        return Comment::with(['owner'])
            ->where('item_id', $id)
            ->where('parent_id', 0)
            ->where('type', 'App\Models\ShowOff')
            ->latest()
            ->paginate(10);
    }

    public function replies($id)
    {
        return Comment::with(['owner'])->where('parent_id', $id)->get();
    }



    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        if(Auth::user()->kyc != 'verified'){
            return response("Forbidden Action", 403);
        }

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->item_id = $request->item_id;
        $comment->type = "App\Models\ShowOff";
        $comment->comment = $request->comment;
        $comment->save();

        $c = $comment;

        $owner = Auth::user();

        $c['owner'] = $owner;
        $showoff = ShowOff::find($request->item_id);
        $showoffowner = $showoff->owner;
        if (Auth::user()->id != $showoff->user_id) {
            // foreach($storyowner as $st){
            $showoffowner->notify(new ShowoffCommentNotification($c));
        }

        return $c;
    }

    public function storeReply(Request $request)
    {
        $request->validate([
            'item_id' => 'required|numeric',
            'parent_id' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        if(Auth::user()->kyc != 'verified'){
            return response("Forbidden Action", 403);
        }

        // Stop if the time duration is lower than 1 minute
        // $query = Comment::where('user_id', Auth::user()->id)->latest()->first();
        // check if previous comment is similer

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->item_id = $request->item_id;
        $comment->type = "App\Models\ShowOff";
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        $c = $comment;

        $owner = Auth::user();

        $c['owner'] = $owner;

        $comments = Comment::with(['owner'])->where(['parent_id' => 0, 'item_id' => $comment->item_id])->where('type', "App\Models\ShowOff")->first();
        // return $comments->user_id;
        if (Auth::user()->id != $comments->user_id) {
            $comments->owner->notify(new ShowoffCommentReplyNotification($comment,  $comments->owner));
        }
        $replies = Comment::with(['owner'])->where(['parent_id' => $comment->parent_id])->where('user_id', '!=', Auth::user()->id)->where('type', "App\Models\ShowOff")->groupBy('user_id')->get();
        // return $replies;
        foreach ($replies as $reply) {
            $reply->owner->notify(new ShowoffCommentReplyNotification($comment, $reply->owner));
        }

        return $c;
    }

    public function destroy(Comment $comment)
    {
        // return $comment->parent_id;
        if ($comment->user_id == Auth::user()->id) {
            // Delete comment
            if ($comment->parent_id == 0) {
                $comment->delete();

                $replies = Comment::where('parent_id', $comment->id)->get();

                foreach ($replies as $reply) {
                    $reply->delete();
                }
            }else{
                $comment->delete();
            }

            return response('Success', 200);
            // DB::table('comments')->where('user_id', Auth::user()->id)->where('comment_id', $id)->delete();
        } else {
            return response("unauthenticated", 401);
        }
    }
}
