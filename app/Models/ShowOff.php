<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShowOff extends Model
{
    use HasFactory;
    

    protected $appends = ['item_type', 'is_saved', 'has_reacted', 'is_owner', 'have_commented', 'reactions_count'];

//test
public function saves(){
    return $this->morphMany(Save::class,'item');
}

     // Owner
     public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
     public function tagged(){
         return $this->hasMany(ShowOffMeta::class, 'show_off_id');
     }

     public function getItemTypeAttribute(){
        return get_class($this);
    }

    public function getIsSavedAttribute(){
       if(Auth::user()){        
            return Save::where('user_id', Auth::user()->id)->where('item_id', $this->id)->where('item_type', get_class($this))->exists();
        }else{
            return false;
        }
    }

    public function getIsOwnerAttribute(){
        if(Auth::user() && $this->owner != null){
            if($this->owner->id == Auth::user()->id){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function reactions(){
        return $this->hasMany(ShowOffReaction::class, 'showoff_id');
    }

    public function getReactionsCountAttribute(){
        return $this->shorten($this->reactions()->count());
    }

    public function getHasReactedAttribute(){
        if(Auth::check()){
        
            if($this->reactions()->where('user_id', Auth::user()->id)->exists()){
            $reactId = $this->reactions()->where('user_id', Auth::user()->id)->first()->reaction;
            $reactionData = React::where('id', $reactId)->first()->reaction;
            return $reactionData;
            }
        }
        
        return false;
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'item_id')->where('type', 'App\Models\ShowOff');
    }

    public function getHaveCommentedAttribute(){
        if(Auth::check()){
            return $this->comments()->where('user_id', Auth::user()->id)->exists();
        }else{
            return false;
        }
    }



    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if(static::whereSlug($slug = $this->str_slug($value))->exists())
        {
            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }

    public function str_slug($value)
    {
        $raw = $value;
        $stripped = trim(preg_replace('/\s+/', '-', $raw));
        $slug = strtolower($stripped);

        //return with user_handle to make it unique
        return $slug;
    }

    public function incrementSlug($slug)
    {
        $max = static::whereName($this->name)->latest('id')->value('slug');

        if(is_numeric($max[-1])){
            return preg_replace_callback('/(\d+)$/', function ($matches){
                return $matches[1] + 1;
            }, $max);
        }
        return "{$slug}-2";
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
