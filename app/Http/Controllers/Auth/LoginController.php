<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/following';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function loginUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            
            $userStatus = User::where(['email'=>$data['email']])->first();
             if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'is_verified'=>1,'status'=>1,'is_blocked'=>1])){
                //   if($userStatus->status == 0 ){
                //      return redirect()->back()->with('error','Your Account is temporary deactivated ! Please contact for more infoo.');
                //     }
                //   if($userStatus->is_verified==0){
                  
                //      return redirect()->back()->with('email','Your Account is not verified! Please check your email for verification');
                //  }
             return redirect('/');
             }

             
             else{
                 if($userStatus == null){
                     return redirect()->back()->with('error','Invalid email or password');
                 }
                if($userStatus->is_verified==0){
                  
                    return redirect()->back()->with('error','Your Account is not verified! Please check your email for verification');
                }
                if($userStatus->status == 0 ){
                    return redirect()->back()->with('error','Your Account is temporary deactivated ! Please contact for more infoo.');
                }
                else{
                    return redirect()->back()->with('error','Invalid email or password');
                }
                  
             }   
         }
    }
}
        

