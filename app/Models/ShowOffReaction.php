<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowOffReaction extends Model
{
    use HasFactory;

    public function showoff(){
        return $this->belongsTo(ShowOff::class, 'showoff_id');
    }
    public function reactby(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
