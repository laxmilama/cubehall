<?php
namespace App\Traits;

use App\Models\AdminPage;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Page;
use App\Models\ProductMeta;

trait HasRolesAndPermissions
{

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if($this->roles->contains('slug', 'admin')){
            return true;
        }
    }
    // public function pages(){
    //     return $this->belongsToMany(AdminPage::class,'admins_pages');
    // }
    public function pages(){
        return $this->belongsToMany(Page::class,'pages_users');
    }
    public function proles(){
        return $this->belongsToMany(Role::class,'pages_roles');
    }
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }
    
    public function pageroles()
    {
        return $this->belongsToMany(Role::class,'pages_roles');
    }
    public function adminpage()
    {
        return $this->belongsToMany(Role::class,'pages_roles','Admin');
    }
    /**
     * @return mixed
     */
    public function pagepermissions()
    {
        return $this->belongsToMany(Permission::class,'pages_permissions');
    }
    
    /**
     * Check if the user has Role
     *
     * @param [type] $role
     * @return boolean
     */
    public function hasRole($role)
    {        
        //
        if( strpos($role, ',') !== false ){//check if this is an list of roles

            $listOfRoles = explode(',',$role);

            foreach ($listOfRoles as $role) {                    
                if ($this->roles->contains('slug', $role)) {
                    return true;
                }
            }
        }else{                
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }
    //product meta insert
    public function productMeta(Request $request){
        $product=new ProducMeta;
        $product->product_id=$order_id;
        $product->page_id=1;
        $product->color=$request->color;
        $product->price=$request->price;
        $product->material=$request->material;
       $product->save();
     return response()->json();
    }
}

