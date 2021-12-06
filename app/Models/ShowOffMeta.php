<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductList;

class ShowOffMeta extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(ProductList::class, 'link_id');
    }
    public function showoff(){
        return $this->belongsTo(ShowOff::class, 'show_off_id');
    }
}
