<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Story extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['reactions_count', 'is_owner', 'comments_count', 'has_reacted', 'have_commented', 'type', 'have_seen'];

    public function getTypeAttribute(){
        return get_class($this);
    }

    public function getIsOwnerAttribute(){
        if(Auth::check()){
            if($this->owner != null && $this->owner->id == Auth::user()->id){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function owner(){
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function product(){
        return $this->belongsTo(ProductList::class, 'product_id');
    }

    public function parlor(){
        return $this->belongsTo(Parlor::class, 'parlor_id');
    }

    public function studio(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reactions(){
        return $this->hasMany(Reaction::class, 'story_id');
    }

    public function getReactionsCountAttribute(){
        return $this->shorten($this->reactions()->count());
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'item_id')->where('type', 'App\Models\Story');
    }

    public function getCommentsCountAttribute(){
        return $this->shorten($this->comments()->count());
    }

    public function getHasReactedAttribute(){
        // return(($this->reactions()->where('user_id', Auth::user()->id)));
        if($this->reactions()->where('user_id', Auth::user()->id)->exists()){
           $reactId = $this->reactions()->where('user_id', Auth::user()->id)->first()->reaction;
           $reactionData = React::where('id', $reactId)->first()->reaction;
           return $reactionData;
        }
        
        return false;
    }

    public function getHaveCommentedAttribute(){
        return $this->comments()->where('user_id', Auth::user()->id)->exists();
    }

    public function getHaveSeenAttribute(){
        return History::where('type', 'Story')
                        ->where('user_id', Auth::user()->id)
                        ->where('item_id', $this->id)
                        ->exists();
    }

    public function shorten($number){
        $suffix = ["", "K", "M", "B"];
        $precision = 1;
        for($i = 0; $i < count($suffix); $i++){
            $divide = $number / pow(1000, $i);
            if($divide < 1000){
                return round($divide, $precision).$suffix[$i];
                break;
            }
        }
    }


}
