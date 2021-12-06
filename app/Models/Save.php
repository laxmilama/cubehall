<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
    protected $fillable=['item_id','item_type','board_id'];
    use HasFactory;

    // public function item(){
        
    // }
    public function item(){
        return $this->morphTo();
    }
}
