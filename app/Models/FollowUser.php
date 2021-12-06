<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUser extends Model
{
    use HasFactory;

    public function followto(){
        return $this->belongsTo(User::class,'followed_to');
    }
    public function followby(){
        return $this->belongsTo(User::class,'followed_by');
    }
}
