<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    use HasFactory;
    public function studio(){
        return $this->belongsTo(Page::class,'page_id');
    }
}
