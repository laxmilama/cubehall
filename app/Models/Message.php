<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function formmessage(){
     return $this->hasOne(User::class,'id','from','id','to');
    }

    // public function formmessage(){
    //     return $this->hasOne(User::class, 'from');
    //    }
}
