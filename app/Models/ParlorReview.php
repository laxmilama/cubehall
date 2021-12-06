<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParlorReview extends Model
{
    use HasFactory;

    public function writer(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function parlor(){
        return $this->belongsTo(Parlor::class,'parlor_id');
    }
}
