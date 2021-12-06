<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagenuser extends Model
{
    use HasFactory;
    public function pageuserroles()
    {
        return $this->belongsToMany(Role::class,'pagesnusers_roles');
    }
    public function pageuserpermissions()
    {
        return $this->belongsToMany(Permission::class,'pagesnusers_permissions');
    }
}
