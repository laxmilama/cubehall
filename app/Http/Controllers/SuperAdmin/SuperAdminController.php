<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
use Auth;
use Session;

class SuperAdminController extends Controller
{
    public function dashboard(){
       
//         if (!Gate::allows('isAdmin')) {
//             return redirect('admin/users');
//  }
//        else{
//         dd("no access");
//        }
        return view('superadmin.dashboard');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
           //echo "<pre>"; print_r($data); die;
           
           $rules=[
               'email' => 'required|email|max:255',
               'password' => 'required',
           ];
   
           $customeMessage=[
               'email.required'=>'Email is required',
               'email.email'=>'Valid Email is required',
               'password.required'=>'Password is required',
           ];
           $this->validate($request,$rules,$customeMessage);
   
           if (Auth::guard('superadmin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
   
               return redirect('admin/dashboard');
           }
              
                else{
                    Session::flash('error_message','Invalid Email or Password');
                 return redirect()->back();
       
           }
       }

        return view('superadmin.login');
    }
    public function logout(){
        Auth::guard('superadmin')->logout();
        return redirect('/admin');
    }
}
