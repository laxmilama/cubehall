<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   // use HasFactory;
   public function users() {

    return $this->belongsToMany(SuperAdmin::class,'users_roles');
        
 }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
    
    public function allRolePermissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
    //  public function  droles(){
    //     return $this->assignRole(Role::class,'Admin');
    //  }
    public function pa()
        {
            return $this->belongsToMany(Page::class, 'pages_roles' )->withPivot('user_id');
        }
}
