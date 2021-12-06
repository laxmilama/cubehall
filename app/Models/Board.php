<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Save;
use App\Models\ShowOff;
use App\Models\ProductList;
use Illuminate\Support\Facades\Auth;

class Board extends Model
{
    use HasFactory;

    protected $appends = ['thumb', 'is_owner', 'count'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getThumbAttribute()
    {
        $pin = $this->hasMany(Save::class, 'board_id')->latest()->take(1)->get();
        if ($pin->count() > 0) {
            // return $pin[0]->type;
            if ($pin[0]->item_type == "App\Models\ProductList") {
                $item = ProductList::where('id', $pin[0]->item_id)->with(['meta' => function ($query) {
                    $query->select('id', 'product_id', 'thumbnail');
                }])->first();
                return '/images/product/small/' . $item->meta->thumbnail;
            } elseif ($pin[0]->item_type == "App\Models\ShowOff") {
                $item = ShowOff::where('id', $pin[0]->item_id)->first();
                return '/images/showoff/small/' . $item->media;
            }
        } else {
            return "/assets/lightBulb.png";
        }
    }

    public function getCountAttribute()
    {
        $pin = $this->hasMany(Save::class, 'board_id')->get();
        return $pin->count();
    }

    public function getIsOwnerAttribute()
    {
        if (Auth::check()) {
            if (Auth::user()->id == $this->user_id) {
                return true;
            }
            return false;
        }
        return false;
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
