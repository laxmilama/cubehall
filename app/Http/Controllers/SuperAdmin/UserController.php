<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\SuperAdmin;
use App\Models\Role;

class UserController extends Controller
{
   public function adminUser(Request $request){
   
       $users=SuperAdmin::get();
       return view('superadmin.users.user',['users'=>$users]);
   }
   public function adminUserAdd(Request $request){
      
    if($request->isMethod('post')){
        $data=$request->all();

       // dd($data);die;
       $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
     $adminuser=new SuperAdmin;
        $adminuser->email=$data['email'];
        $adminuser->name=$data['name'];
      
        $adminuser->password=Hash::make($request->password);
        $adminuser->status=1;
        $adminuser->save();
        // $adminuser->id;

        // $admins=new Admin([
        //     'page_id'=> $adminuser->id,
        // ]);
        


        if($request->role != null){
            $adminuser->roles()->attach($request->role);
            $adminuser->save();
        }

        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $adminuser->permissions()->attach($permission);
                $adminuser->save();
            }
        }

        return redirect('admin/users');
       }
       if($request->ajax()){
        $roles = Role::where('id', $request->role_id)->first();
        $permissions = $roles->permissions;

        return $permissions;
    }
       $roles=Role::get();
      // dd($roles);
       return view('superadmin.users.add_admin_user',['roles'=>$roles]);
   }

   public function editAdminUser(Request $request, SuperAdmin $superadmin){
    //echo "name";die; 
   // dd($superadmin); 
  
    if($request->isMethod('post')){
        $data=$request->all();  
       
    //validate the fields
          $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $superadmin->email=$data['email'];
        $superadmin->name=$data['name'];
      
        $superadmin->password=Hash::make($request->password);
        $superadmin->status=1;
        $superadmin->save();
        
        $superadmin->roles()->detach();
        $superadmin->permissions()->detach();

        if($request->role != null){
            $superadmin->roles()->attach($request->role);
            
            $superadmin->save();
        }

        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $superadmin->permissions()->attach($permission);
                $superadmin->save();
            }
        }
        return redirect('/admin/users');
    }
         
        
        $roles = Role::get();
        $userRole = $superadmin->roles->first();
        if($userRole != null){
            $rolePermissions = $userRole->allRolePermissions;
          
        }else{
            $rolePermissions = null;
        }
       // dd($rolePermissions);
        $userPermissions = $superadmin->permissions;

         //dd($userPermissions);

        return view('superadmin.users.edit_superadmin', [
            'superadmin'=>$superadmin,
            'roles'=>$roles,
            'userRole'=>$userRole,
            'rolePermissions'=>$rolePermissions,
            'userPermissions'=>$userPermissions
            ]);

    }
   }

