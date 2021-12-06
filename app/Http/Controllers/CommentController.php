<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Story;
use App\Models\User;
use App\Notifications\StoryCommentNotification;
use App\Notifications\StoryReplyCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
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
            'item_id' => 'required|numeric',
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
        $comment->type = "App\Models\Story";
        $comment->comment = $request->comment;
        $comment->save();

        $c= $comment;

        $owner = Auth::user();

        $c['owner']=$owner;

        $story = Story::find($request->item_id);
      //  return $story->owner;
        $storyowner= $story->owner->user;
        foreach($storyowner as $st){
        if(Auth::user()->id != $st->id){
       
        $st->notify(new StoryCommentNotification($c));
        }
    }
     
      // $comment->story->studio->notify(new StoryCommentNotification($comment));

        return $c;
        
    }

    public function storeReply(Request $request)
    {
        $request->validate([
            'storyId' => 'required|numeric',
            'parentId' => 'required|numeric',
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
        $comment->item_id = $request->storyId;
        $comment->type = "App\Models\Story";
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parentId;
        $comment->save();

        $c= $comment;

        $owner = Auth::user();

        $c['owner']=$owner;

        $comments=Comment::with(['owner'])->where(['parent_id'=>0,'item_id'=>$comment->item_id])->where('type',"App\Models\Story")->first();
        //  return $comment->user_id;
        if(Auth::user()->id != $comments->user_id){
        $comments->owner->notify(new StoryReplyCommentNotification($comment,  $comments->owner));
        }
        $replies=Comment::with(['owner'])->where(['parent_id'=>$comment->parent_id])->where('user_id','!=',Auth::user()->id)->where('type',"App\Models\Story")->groupBy('user_id')->get();
       // return $replies;
        foreach($replies as $reply){
            
            $reply->owner->notify(new StoryReplyCommentNotification($comment, $reply->owner));
        }
        $this->replies($comments);
        foreach($this->replies($comments->id) as $reply){
            
        }
        return $c;
        
    }

    public function replies($id){
        $comments = Comment::with(['owner'])->where('parent_id', $id)->get();
        return $comments;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        // return $comment;
        if($comment->user_id == Auth::user()->id)
        {
            // Delete comment
            $comment->delete();

            $replies = Comment::where('parent_id', $comment->id)->get();

            foreach($replies as $reply){
                $reply->delete();
            }
            // DB::table('comments')->where('user_id', Auth::user()->id)->where('comment_id', $id)->delete();
        }

        return $comment->id;
    }
}
