<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParlorSection extends Model
{
    use HasFactory;
    public function categories(){
        return $this->hasMany(ParlorCategory::class,'section_id')
            ->with(['subcategories' => function($query){
            }])
            ->where(['parent_id'=>0]);
    }
}
