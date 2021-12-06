<?php

namespace App\Http\Controllers;

use App\Models\follow;
use App\Models\Page;
use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FollowController extends Controller
{

    public function follow(Request $request)
    {
        if(Follow::where('followed_by', Auth::user()->id)->where('followed_to', $request->pageId)->exists()){
            return response("Exists");
        }
        $follow = new Follow;
        $follow->followed_by = Auth::user()->id;
        $follow->followed_to = $request->pageId;
         $follow->save();

    
        //  Notification
        // User of the studio

      $users=User::select('id','name', 'slug', 'email')->where('id',$follow->followed_by)->get();
  
      $followtoss=Page::with('user')->where('id',$follow->followed_to)->select('id','name')->get();

        foreach ($followtoss as $followtos) {
          
            $followto=$followtos->user;
           
                foreach ($followto as $follow) {
                    
                    $follow->notify(new FollowNotification($users,$follow));
                
                }
        }
        return response('OK');
    }
    

    public function unfollow($pageId)
    {
        // dd($pageId);
        DB::table('follows')->where('followed_by', Auth::user()->id)->where('followed_to', $pageId)->delete();

        

    }

    public function isFollowedBy(){
        
    }

    public function isFollowingTo($page){
        
    }


    public function following(){
        return $this->belongsTo(Page::class, 'followed_by');
    }

    public function followers(){
              
    }
}
