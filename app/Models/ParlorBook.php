<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ParlorBook extends Model
{
    use HasFactory;

    protected $fillabel = ['attended_at'];

    public function ticket(){
        return $this->belongsTo(ParlorTicket::class, 'ticket_id');
    }
    public function parlor(){
        return $this->belongsTo(Parlor::class, 'parlor_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review(){
       return  $this->hasOne(ParlorReview::class, 'booked_id')->select('review', 'id', 'booked_id', 'review');
    }
}
