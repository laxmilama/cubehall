<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class follow extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'followed_to')->get();
    }
    public function followto(){
        return $this->belongsTo(Page::class,'followed_to');
    }
    public function followby(){
        return $this->belongsTo(User::class,'followed_by');
    }
}
