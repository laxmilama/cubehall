<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parlor extends Model
{
    use HasFactory;

    protected $appends = ['type', 'sell_count', 'reviews_count', 'star_count'];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getTypeAttribute(){
        return get_class($this);
    }

    public function owner(){
        return $this->belongsTo(Page::class, 'page_id')->select('id', 'name','slug');
    }

    public function studio(){
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function host(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setSlugAttribute($value)
    {
        if(static::whereSlug($slug = $this->str_slug($value))->exists())
        {
            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }

    public function tickets(){
        return  $this->hasMany(ParlorTicket::class, 'parlor_id');
    }

    public function reviews(){
        return  $this->hasMany(ParlorReview::class, 'parlor_id');
    }

    public function reviewsTop(){        
        return  $this->reviews()->limit(6);
    }

    public function getReviewsCountAttribute(){
        return $this->reviews()->count();
    }

    public function reviewsCount(){
        return $this->reviews()->count();
    }

    public function recentsell(){
        return $this->hasOne(ParlorBook::class, 'parlor_id')->orderBy('created_at', 'desc');
    }

    public function getStarCountAttribute(){
        $data = ParlorReview::where('parlor_id', $this->id)->latest()->limit(10)->get('rating');
        $total = $data->count();
        if($total == 0){
            $total = 1;
        }
        $score = 0;
        foreach($data as $rating){
            $score +=$rating->rating;
        }
        $grace = round($score/$total, 2);

        return $grace;
    }

    public function ticket(){        
        return $this->hasOne(ParlorTicket::class, 'parlor_id')
            ->orderBy('created_at', 'DESC');
    }

    public function getSellCountAttribute(){
        return $this->hasMany(ParlorBook::class, 'parlor_id')->count();
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
        $max = static::whereTitle($this->title)->latest('id')->value('slug');

        if(is_numeric($max[-1])){
            return preg_replace_callback('/(\d+)$/', function ($matches){
                return $matches[1] + 1;
            }, $max);
        }
        return "{$slug}-2";
    }
}
