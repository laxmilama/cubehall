<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Associate extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['visits_count', 'sells_count', 'sells_amount'];

    // Product Owner
    public function owner(){
       return $this->belongsTo(Page::class, 'owner_id');
    }

    // Product related to this link
    public function product(){
        return $this->belongsTo(ProductList::class, 'product_id');
    }

    // all the visits
    public function visits(){
        return $this->hasMany(AssociateVisit::class);
    }

    // Total Visits or link clicked
    public function getVisitsCountAttribute()
    {
        return $this->visits()->count();
    }

    // Sells details
    public function sells(){
        return $this->hasMany(AssociateMeta::class);
    }

    // Total no. of sells
    public function getSellsCountAttribute()
    {
        return $this->sells()->count();
    }

    // Earned Ammount
    public function getSellsAmountAttribute()
    {
        return $this->sells()->where('status', 0)->sum('amount');
    }
}
