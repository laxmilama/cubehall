<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   // use HasFactory;
   public function sections(){
    return $this->belongsTo('App\Models\Section','section_id')->select('id','name');
   }

   public function subcategories(){
      return $this->hasMany('App\Models\Category','parent_id')->where('status',1)->select('id', 'name', 'parent_id', 'status', 'slug');
   }
   
   public function parentcategory(){
      return $this->belongsTo('App\Models\Category','parent_id')->select('id','name');
   }

   public function product(){
    return $this->hasOne(ProductList::class, 'category_id')->where('status', 1)->latest();
   }


   public function user()
   {
       return $this->belongsTo('App\Models\SuperAdmin', 'superadmin_id');
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
