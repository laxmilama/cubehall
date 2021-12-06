<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateVisit extends Model
{
    use HasFactory;

    // Product related to this link
    public function product(){
        return $this->belongsTo(ProductList::class, 'product_id');
    }

}
