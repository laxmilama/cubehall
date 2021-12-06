<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    public function reacts(){
        return React::all();
    }
    public function story(){
        return $this->belongsTo(Story::class,'story_id');
    }
    public function reacter(){
        return $this->belongsTo(User::class,'user_id');
    }
}
