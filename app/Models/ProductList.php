<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductList extends Model
{
    use HasFactory, HasRolesAndPermissions;
    protected $guarded = []; 
    protected $table = 'product_lists';

   //protected $appends = ['type', 'ratings_count', 'reviews_count', 'is_saved'];

    protected $appends = ['item_type', 'ratings_count', 'reviews_count', 'is_saved'];

//test
    public function saves(){
        return $this->morphMany(Save::class,'item');
    }

    public function getItemTypeAttribute(){
        return get_class($this);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class,'product_id');
    }
    
    public function metas(){
        return $this->hasMany(ProductMeta::class,'product_id');
    }

    public function meta(){
        return $this->hasOne(ProductMeta::class,'product_id')
                ->orderBy('created_at', 'DESC');
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function tags(){
        return $this->hasMany(ShowOffMeta::class, 'link_id');
    }

    public function impressions(){
        return $this->hasMany(Impression::class, 'item_id')
            ->where('type', 'ProductList');
    }

    public function getImpressionCountAttribute(){
        return $this->impressions()->count();
    }

    public function getTotalTagsAttribute(){
        return $this->tags()->count();
    }

    // Associates
    public function associates(){
        return $this->hasMany(Associate::class, 'product_id');
    }

    public function associateCount(){
        return $this->associates()->count();
    }

    // Owner
    public function owner(){
        return $this->belongsTo(Page::class, 'page_id');
     }

    //  Reviews
    public function reviews(){
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function shipping(){
        return $this->belongsToMany(ShippingAddress::class,'proshipping_addresses');
    }

    public static function getCurrency($price){
        //dd($price);
        $getCurrencies=Currency::where('status',1)->get();
       
        foreach($getCurrencies as $currency){
           // dd($currency->currency_code);
            if($currency->currency_code=="EURO"){
                $EURO_Rate=round($price/$currency->exchange_rate,2);  
            }
           else if($currency->currency_code=="YEN"){
                $YEN_Rate=round($price/$currency->exchange_rate,2);  
            }
           else if($currency->currency_code=="USD"){
                $USD_Rate=round($price/$currency->exchange_rate,2);
                //dd($USD_Rate);
            }
            else if($currency->currency_code=="INR"){
                $INR_Rate=round($price/$currency->exchange_rate,2);
            }
    
        }
        $currencyArr=array('EURO_Rate'=>$EURO_Rate,'YEN_Rate'=>$YEN_Rate,'USD_Rate'=>$USD_Rate,'INR_Rate'=>$INR_Rate);
        //dd($currencyArr);
        return $currencyArr;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getIsSavedAttribute(){
        if(Auth::user()){        
             return Save::where('user_id', Auth::user()->id)->where('item_id', $this->id)->where('item_type', class_basename(get_class($this)))->exists();
         }else{
             return false;
         }
     }

    public function getRatingsCountAttribute()
    {
        $total = $this->reviews()->count();
        if($total > 0){
            $rating = round($this->reviews()->sum('rating')/$total, 1);
        }
        else
        {
            $rating = 0;
        }        
        return $rating;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if(static::whereSlug($slug = $this->str_slug($value))->exists())
        {
            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }

    public function str_slug($value)
    {
        $raw = $value;
        $stripped = trim(preg_replace('/\s+/', '-', $raw));
        $slug = strtolower($stripped);

        //return with user_handle to make it unique
        return $slug;
    }

    public function incrementSlug($slug)
    {
        $max = static::whereName($this->name)->latest('id')->value('slug');

        if(is_numeric($max[-1])){
            return preg_replace_callback('/(\d+)$/', function ($matches){
                return $matches[1] + 1;
            }, $max);
        }
        return "{$slug}-2";
    }


}
