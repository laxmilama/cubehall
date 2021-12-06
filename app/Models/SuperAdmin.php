<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Authenticatable
{
   // use HasFactory;
   use Notifiable, HasRolesAndPermissions;
    protected $guard='superadmin';
    protected $fillable=[
        'name','email','password','status','created_at','updated_at' ,
    ];
    
        protected $hidden= [
        'password','remember_token',
        ];
      
}
