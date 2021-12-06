<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function parlor(){
        return $this->belongsTo(Parlor::class, 'item_id');
    }

    public function product(){
        return $this->belongsTo(ProductList::class, 'item_id');
    }

    public function studios(){
        return $this->hasManyThrough(Page::class, ProductList::class);
    }

    public function story(){
        return $this->belongsTo(Story::class);
    }
}
