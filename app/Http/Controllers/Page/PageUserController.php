<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Models\Pagenuser;
use App\Models\Page;
use App\Models\User;

class PageUserController extends Controller
{
    public function addPageUser(Request $request, Page $page){
        $users=User::pluck('email', 'id');
        $roles = Role::get();
       // $page=Page::get();
     //dd($page->id);
      
        if($request->isMethod('post')){
            $data=$request->all();
    
          // dd($data);die;
        //    $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
      
        //  $request->page_id=$pagenuser;
        //  $request->users()->attach($users);
          
          //  $adminuser->save();
           // $admin=Page::pageroles()->plunk('name');
           // $admin->pageroles()->pluck('name');
         //  dd($admin);
           // $pageadmin->pages()->attach($adminuser->id);
        //    
          // dd($pageadmin);
          $user_id = User::select('id')->where('email', $request->email)->first();
        //dd($user_id->id);
          // $da = User::select('id')->where('email', 'LIKE', $request->email.'%')
          // ->get();
       // dd($da);
               //$page->page_id=$page->id;
           // $page->users()->attach($da);
               // dd($page->users());
             //  $page->save();
        //  dd($roles->roles);
               if($request->role != null){
               // dd($data);
                $page->pageroles()->attach($request->role,['user_id'=>$user_id->id]);
               // $page->pageroles()->attach($request->role);
               // dd($adminuser);
                $page->save();
            }
           }
          // dd($request->role);
         

        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $page->pagepermissions()->attach($permission,['user_id'=>$user_id->id]);
                $page->save();
            }
        }

      //  return redirect('admin/pages');
        if($request->ajax()){
            $data = User::select('id')->where('email', 'LIKE', $request->email.'%')
            ->get();

        $output = '';
       
        if (count($data)>0) {
          
            $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
          
            foreach ($data as $row){
               
                $output .= '<li class="list-group-item">'.$row->email.'</li>';
                
            }
          
            $output .= '</ul>';
          
        }
        else {
         
            $output .= 'No results';
            return $output;
        }
     
            $roles = Role::where('id', $request->role_id)->first();
            $permissions = $roles->permissions;
    
            return $permissions;
        }
        
        // dd($roles);
        return view('page.pageadmin.add_admins',['roles'=>$roles,'page'=>$page]);
    }
}
