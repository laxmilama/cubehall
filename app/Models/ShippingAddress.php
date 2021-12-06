<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    // shipping
    public function shipping(){
        return $this->belongsToMany(ProductList::class,'proshipping_addresses');
    }
   
}
