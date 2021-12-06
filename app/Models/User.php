<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NotificationChannels\WebPush\HasPushSubscriptions; //import the trait
use Carbon\Carbon;
use function PHPUnit\Framework\isNull;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndPermissions, HasPushSubscriptions;

    // use HasPushSubscriptions; // add the trait to your class

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'google_id',
        'verification_code',
        'number'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Attributes to attatch to user
     */
    protected $appends = [
        'profile_image',
        'type',
        'following_count',
        'followers_count',
        'can_showoff',
        'views',
        'number',
        'kyc',
        'is_followed',
    ];
    public function pagepermission()
    {
        return $this->belongsToMany(Permission::class, 'pages_permissions')->withPivot('user_id');
    }

    public function getTypeAttribute()
    {
        return class_basename(get_class($this));
    }

    public function pagess()
    {
        return $this->belongsToMany(Page::class, 'pages_users');
    }

    public function associates()
    {
        return $this->hasMany(Associate::class, 'user_id');
    }

    public function product()
    {
        return $this->hasOne(ProductList::class, 'user_id');
    }

    public function latestmessage(){
        // return $this->morphOne(Message::class, 'from')->orWhere('to', '=', $this->id)->latest();
        return $this->hasOne(Message::class, 'from');
    }
    public function recentmessage(){
        $this->belongsTo(Message::class, '');
    }
    public function latesttomessage(){
        // return $this->morphOne(Message::class, 'from')->orWhere('to', '=', $this->id)->latest();
        return $this->hasOne(Message::class,'to')->latest();
    }
  

    public function GetNumberAttribute()
    {
        // return $this->hasMany(UserPhoneNumber::class, 'user_id');
        return UserPhoneNumber::select('number')->where('user_id', $this->id)->latest()->first();
    }

    public function GetKycAttribute()
    {
        $kyc = KYC::where('user_id', $this->id)->where('verified', 1)->latest()->first();
        if ($kyc) {
            return 'verified';
        }
        return 'unverified';
    }

    public function getProfileImageAttribute()
    {
        if (UserProfile::where("user_id", $this->id)->exists()) {
            return UserProfile::where("user_id", $this->id)->latest('id')->first()->image;
        } else {
            return '303eb-e9be-3fb2a7-caf3df.webp';
        }
    }

    public function atleastOneShowoff()
    {
        return $this->hasOne(ShowOff::class);
    }


    public function fiveShowoffs(){
        return $this->hasMany(ShowOff::class)
            ->limit(5);
    }

    public function following()
    {
        return $this->hasMany(FollowUser::class, 'followed_by');
    }

    public function followingStudios()
    {
        return $this->hasMany(follow::class, 'followed_by');
    }

    public function getFollowingCountAttribute()
    {
        return $this->shorten($this->following()->count() + $this->followingStudios()->count());
    }


    public function followers()
    {
        // $users = FollowUser::where('followed_to', Auth::user()->id)->pluck('followed_by');
        // return  User::whereIn('id', $users)->latest()->get();
        return $this->hasMany(FollowUser::class, 'followed_to');
    }

    public function getViewsAttribute()
    {
        // return $this->hasManyThrough(History::class, ShowOff::class, 'user_id', 'item_id');
        // return $this->hasMany(ShowOff::class, 'user_id');
        $time = 720; //in hours  24 x 30 = 720 hours = one month

        $showoffIds = ShowOff::where('user_id', $this->id)->pluck('id');
        $history = History::whereIn('item_id', $showoffIds)->where('created_at', '>=', Carbon::now()->subHours($time))->where('type', 'App\Models\ShowOff')->get()->count();

        return $this->shorten($history);
    }

    public function getCanShowOffAttribute()
    {
        if (Auth::check()) {
            $orders = Order::where('user_id', Auth::user()->id)
                ->get();
            if ($orders->count() > 0 && $this->kyc == 'verified') {
                return true;
            }else if (count(Auth::user()->pages) > 0 && $this->kyc == 'verified') {
                $products = collect([]);
                foreach (Auth::user()->pages as $page) {
                    $products = $products->concat($page->product->pluck('id'));
                }
                if($products->count()>0){
                    return true;
                }
            }
        }
        return false;
    }

    public function getFollowersCountAttribute()
    {
        return $this->shorten($this->followers()->count());
    }

    // Bio
    public function getBioAttribute()
    {
        $bio = UserBio::where('user_id', $this->id)->latest()->first();
        if($bio)
        {
            return $bio->bio;
        }else{
            return "";
        }
    }


    public function getIsFollowedAttribute()
    {
        if (Auth::check()) {
            if (Auth::user()->id == $this->id) {
                return true;
            }
            if (Auth::user()) {
                return FollowUser::where('followed_by', Auth::user()->id)->where('followed_to', $this->id)->exists();
            }
        } else {
            return false;
        }
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
}
