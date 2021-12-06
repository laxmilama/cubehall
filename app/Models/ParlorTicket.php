<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParlorTicket extends Model
{
    use HasFactory;

    protected $appends = ['sells_count', 'can_attend'];


    public function parlor(){
        return $this->belongsTo(Parlor::class, 'parlor_id');
    }
    
    public function sells(){
        return $this->hasMany(ParlorBook::class, 'ticket_id');
    }
    public function getTotalSellsAttribute(){
        return $this->sells->count();
    }
    public function getIsAvailableAttribute(){
        if($this->total_sells < $this->capacity){
            return true;
        }
        return false;
    }
    
    public function getSellsCountAttribute(){
        return $this->sells()->count();
    }
    public function getCanAttendAttribute(){
        if($this->time <= Carbon::now()->addMinutes(15) && $this->time >= Carbon::now()->subMinutes(5))
        {
            return true;
        }else{
            return false;
        }
    }
}
