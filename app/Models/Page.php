<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Page extends Model
{
    use HasFactory;
    protected $guard = 'page';
    protected $appends = [
        'followers_count',
        'products_count',
        'story_count',
        'parlors_count',
        'profile_image',
        'cover_image',
        'reviews_count',
        'is_followed',
        'brand_color',
        'type',
        'studio_rating'
    ];



    public function users()
    {
        return $this->belongsToMany(User::class, 'pages_users', 'page_id', 'user_id');
    }

    public function getTypeAttribute()
    {
        return class_basename(get_class($this));
    }

    public function userspagerole()
    {
        return $this->belongsToMany(User::class, 'pages_roles_users', 'page_id', 'user_id', 'role_id');
    }
    // public function pages(){
    //     return $this->belongsToMany(AdminPage::class,'admins_pages');
    // }
    public function pages()
    {
        return $this->belongsToMany(Page::class, 'pages_users');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class, 'pages_roles')->withPivot('user_id');
    }
    public function pageroles()
    {
        return $this->belongsToMany(Role::class, 'pages_roles')->withPivot('user_id');
    }
    public function pagepermissions()
    {
        return $this->belongsToMany(Permission::class, 'pages_permissions')->withPivot('user_id');
    }
    public function userpermission()
    {
        return $this->belongsToMany(User::class, 'pages_permissions')->withPivot('user_id');
    }
    public function product()
    {
        return $this->hasMany(ProductList::class)
            ->where('status', 1);
    }

    public function atleastOneProduct()
    {
        return $this->hasOne(ProductList::class)
            ->where('status', 1);
    }

    public function atleastOneParlor()
    {
        return $this->hasOne(Parlor::class)
            ->where('status', 1);
    }

    public function fiveProducts(){
        return $this->hasMany(ProductList::class)
            ->where('status', 1)
            ->take(6);
    }

    public function fiveParlors(){
        return $this->hasMany(Parlor::class)
            ->where('status', 1)
            ->take(6);
    }

    public function sells()
    {
        return $this->hasManyThrough(OrderProduct::class, ProductList::class, 'page_id', 'product_id', 'id', 'page_id')
            ->orderBy('created_at', 'DESC');
    }
    // public function permi(){
    //     return $this->belongsToMany(Permission::class,'roles_permissions');
    // }

    public function ro()
    {
        return $this->belongsToMany(Role::class, 'pages_roles')->withPivot('user_id');
    }

    public function recentStories()
    {
        return $this->hasMany(Story::class)->where('created_at', '>=', Carbon::now()->subHours(24));
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = $this->str_slug($value))->exists()) {
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

        if (is_numeric($max[-1])) {
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $max);
        }
        return "{$slug}-2";
    }

    // reviews

    public function followers()
    {
        return $this->hasMany(follow::class, 'followed_to');
    }

    public function getIsFollowedAttribute()
    {
        // return Auth::user()->id;
        if (Auth::user()) {
            return $this->followers()->where('followed_by', Auth::user()->id)->exists();
        } else {
            return false;
        }
    }

    public function getFollowersCountAttribute()
    {
        return $this->shorten($this->followers()->count());
    }

    public function getBrandColorAttribute()
    {
        if (StudioColor::where("page_id", $this->id)->exists()) {
            return StudioColor::where("page_id", $this->id)->latest('id')->first()->color;
        } else {
            return "#f64a6d";
        }
    }

    public function getStudioRatingAttribute()
    {
        $total = $this->reviews()->latest()->take(20)->count();
        if($total > 0){
            $rating = round($this->reviews()->sum('rating')/$total, 1);
        }else{
            $rating =0;
        }

        $parlorTotal = $this->parlorReviews()->latest()->take(20)->count();
        if($parlorTotal > 0){
            $parlorRating = round($this->reviews()->sum('rating')/$total, 1);
        }else{
            $parlorRating =0;
        }

        if($rating > 0 && $parlorRating> 0){
            return ($rating + $parlorRating)/2;
        }

        if($rating == 0){
            return $parlorRating;
        }else{
            return $rating;
        }
    }

    // Product Count
    public function getProductsCountAttribute()
    {
        return $this->product()->count();
    }

    // stories of this studio
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    // stories count
    public function getStoryCountAttribute()
    {
        return $this->stories()->count();
    }

    public function parlors()
    {
        return $this->hasMany(Parlor::class);
    }

    public function getParlorsCountAttribute()
    {
        return $this->hasMany(Parlor::class)->where('status', 1)->count();
    }

    public function getProfileImageAttribute()
    {
        if (StudioProfile::where("page_id", $this->id)->exists()) {
            return StudioProfile::where("page_id", $this->id)->latest('id')->first()->image;
        } else {
            return '528bf-287be1-a5cf-8e7c4c-f237b.webp';
        }
    }

    public function getCoverImageAttribute()
    {
        if (StudioCover::where("page_id", $this->id)->exists()) {
            return StudioCover::where("page_id", $this->id)->latest('id')->first()->image;
        } else {
            return '7812-08b4-7eb61a-933f40-0b0a.webp';
        }
    }

    public function reviews()
    {
        // return ProductReview::where("page_id", $this->id)->get();
        return $this->hasMany(ProductReview::class);
    }

    public function parlorReviews(){
        return $this->hasMany(ParlorReview::class);
    }

    public function getReviewsCountAttribute()
    {

        return $this->shorten($this->reviews()->count());
    }

    public function shorten($number)
    {
        $suffix = ["", "K", "M", "B"];
        $precision = 1;
        for ($i = 0; $i < count($suffix); $i++) {
            $divide = $number / pow(1000, $i);
            if ($divide < 1000) {
                return round($divide, $precision) . $suffix[$i];
                break;
            }
        }
    }

    public function studioaddress(){
        return $this->hasOne(StudioAddress::class);
    }


    // payment
    public function payment(){
        return $this->hasMany(StudioPayment::class);
    }
}
