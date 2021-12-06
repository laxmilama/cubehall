<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    public function orderproduct(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function product(){
        return $this->belongsTo(ProductMeta::class,'products_meta_id');
    }
    // public function products(){
    //     return $this->belongsTo(ProductMeta::class,'products_meta_id');
    // }
    public function studioes(){
        return $this->belongsTo(Page::class,'page_id');
    }
    public function customers(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function delivered(){
        return $this->belongsTo(Order::class,'order_id');
    }

    public function review(){
        return  $this->hasOne(ProductReview::class)->select('review', 'id', 'order_product_id', 'order_id');
    }
}
