<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParlorCategory extends Model
{
    public function subcategories(){
        return $this->hasMany(ParlorCategory::class,'parent_id');
     }

    public function parlor(){
        return $this->hasOne(Parlor::class, 'theme');
    }
}
