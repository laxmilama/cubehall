<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    public function productlist()
    {
        return $this->belongsTo(ProductList::class,'product_id');
    }
    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function writer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
