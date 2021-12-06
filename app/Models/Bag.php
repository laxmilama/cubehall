<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illumminate\Support\Facades\View;
use App\Models\ProductList;
use App\Models\ProductMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

class Bag extends Model
{
    protected $guard = [];
    protected $fillable = ['coupon'];
    use HasFactory;

    public static function userBagItems()
    {
        if (Cookie::has('_uid')) {
            $uid = Cookie::get('_uid');
        } else {
            $now = Carbon::now();
            $rand = mt_rand(1000000, 9999999);
            $u = $now .  $rand;
            $uid = hash('sha256', $u);
            Cookie::queue('_uid', $uid, 2628000);
        }

        if (Auth::check()) {
            $userBagItems = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->with(['shipping' => function ($db) {
                    }]);
                }]);
            }, 'store' => function ($query) {
            }, 'coupon'])
                // }, 'coupon','bagmetaproduct.productmeta.shipping'])
                ->where('user_id', Auth::user()->id)
                ->orWhere('session_id', $uid)
                ->orderBy('id', 'Desc')
                ->get()
                ->groupBy('page_id');
        } else {
            $userBagItems = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product']);
            }, 'store' => function ($query) {
            }, 'coupon'])
                ->where('session_id', $uid)
                ->orderBy('id', 'Desc')
                ->get()
                ->groupBy('page_id');
        }
        return $userBagItems;
    }

    public function defaultAddress()
    {
        return $this->hasOne(DeliveryAddress::class, 'user_id')->where('selected', 1);
    }
    public function store()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id')
            ->where("expires_at", ">", Carbon::now());
    }
    public function bagproduct()
    {
        return $this->belongsTo(ProductList::class, 'product_id');
    }
    public function bagmetaproduct()
    {
        return $this->belongsTo(ProductMeta::class, 'productmeta_id');
    }
    //get price
    public static function getProductPrice($product_id, $size)
    {

        $productPrice = ProductMeta::select('price')->where(['id' => $product_id])->first()->toarray();

        return $productPrice['price'];
    }
    public static function getProductMetaPrice($product_id)
    {
        $productPrice = ProductMeta::select('price')->where(['id' => $product_id])->first();
        //dd($productPrice);
        return $productPrice['price'];
    }
}
