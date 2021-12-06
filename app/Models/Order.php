<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $appends = ['is_complete'];

    public function orders()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
    public function products()
    {
        return $this->hasMany(ProductList::class, 'product_id');
    }
    public function deliveryaddress()
    {
        return $this->belongsTo(DeliveryAddress::class, 'delivery_id');
    }
    public function customers()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function getIsCompleteAttribute()
    // {
    //    return  $this->orders()->whereNotIn('status', ['new', 'processing', 'shipping'])->get();
         
    // }
}
