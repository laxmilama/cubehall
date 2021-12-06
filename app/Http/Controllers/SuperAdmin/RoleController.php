<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function role(){
        $roles=Role::with('permissions')->get();
        return view('superadmin.role.roles',['roles'=>$roles]);
    }
    //add role
 public function addRole(Request $request){
    
        if($request->isMethod('post')){
            $data=$request->all();
           // dd($request->roles_permissions);die;
           $request->validate([
            'user_role' => ['required', 'string', 'max:255'],
            'role_slug' => ['required', 'string', 'max:255'],
            
            'roles_permissions' => ['required', 'string', 'max:255'],
        ]);
         $role=new Role;
            $role->name=$data['user_role'];
            $role->slug=$data['role_slug'];
            
            $role->save();
            
            $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions
       // dd(  $listOfPermissions);
            foreach ($listOfPermissions as $permission) {
                $permissions = new Permission();
                $permissions->name = $permission;
                $permissions->slug = strtolower(str_replace(" ", "-", $permission));
                $permissions->save();
                $role->permissions()->attach($permissions->id);
                $role->save();
            } 
            return redirect('admin/roles');
           }

        return view('superadmin.role.add_roles');
    }
   public function editRole(Request $request,Role $role) {
    
    if($request->isMethod('post')){
        $data=$request->all();
     
       $request->validate([
        'user_role' => ['required', 'string', 'max:255'],
        'role_slug' => ['required', 'string', 'max:255'],
        
        //'roles_permissions' => ['required', 'string', 'max:255'],
    ]);
     
        $role->name=$data['user_role'];
        $role->slug=$data['role_slug'];
        
        $role->save();

        $role->permissions()->delete();
        $role->permissions()->detach();
        
        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions
   
   //dd($listOfPermissions);
        foreach ($listOfPermissions as $permission) {
             $permissions = new Permission();    
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace(" ", "-", $permission));
            $permissions->save();
            
            $role->permissions()->attach($permissions->id);
            $role->save();
        }
        //dd(  $permissions);
        return redirect('/admin/roles');
    }
  
    // $roleDetails=Role::where(['id'=>$id])->first();
    // dd($roleDetails);
   return view('superadmin.role.edit_roles',['roleDetails'=>$role]);
    
   }

   //delete roles
   public function deleteRole(Role $role){
        $role->permissions()->delete();
        $role->delete();
        $role->permissions()->detach();

        return redirect('/admin/roles');
   }
}
