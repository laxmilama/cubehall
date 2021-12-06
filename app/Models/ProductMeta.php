<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Auth as FacadesAuth;

class ProductMeta extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'products_metas';

    protected $fillable = ['page_id', 'product_id', 'colorname'];
    protected $casts = [
        'colorname' => 'array'
    ];

    protected $appends = ['availability', 'available'];

    public function productmeta()
    {
        return $this->belongsTo(ProductList::class, 'product_id');
    }

    public function allMeta()
    {
        return $this->hasMany(ProductMeta::class, 'product_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductList::class, 'product_id');
    }

    public function sells(){
        return $this->hasMany(OrderProduct::class, 'products_meta_id');
    }

    public function getAvailabilityAttribute()
    {
        if ($this->product->commission == 1) {
                return 'PreOrder';            
        } else {
            if ($this->available > 5) {
                return 'InStock';
            } else if ($this->available <= 5 && $this->available > 0) {
                return 'LimitedAvailability';
            } else {
                return 'SoldOut';
            }
        }
    }

    public function getAvailableAttribute()
    {
        $sells = OrderProduct::where('products_meta_id', $this->id)->sum('quantity');
        // if($sells)
        if ($this->stock - $sells <= 0) {
            return 0;
        }
        return $this->stock - $sells;
    }

}
