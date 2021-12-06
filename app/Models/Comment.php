<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = ['replies_count', 'reacts_count', 'have_reacted', 'is_my_comment'];

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function story(){
        return $this->belongsTo(Story::class, 'item_id');
    }

    public function showoff(){
        return $this->belongsTo(ShowOff::class, 'item_id');
    }

    public function getRepliesCountAttribute()
    {
        return (int)$this->replies()->count();
    }

    public function reacts(){
        return $this->hasMany(CommentReact::class, 'comment_id');
    }

    public function getReactsCountAttribute()
    {
        return (int)$this->reacts()->count();
    }

    public function getHaveReactedAttribute(){
        // return(($this->reactions()->where('user_id', Auth::user()->id)));
        return $this->reacts()->where('user_id', Auth::user()->id)->exists();
    }

    public function getIsMyCommentAttribute(){
        return $this->where('user_id', Auth::user()->id)->exists();
    }
}
// Associate::where('user_id', $data->associator)->where('product_id', $data->listid)->first();