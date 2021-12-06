<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Exception;
use App\Models\User;
use App\Models\SuperAdmin;
use Carbon\Carbon;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Notification;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
    

        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(Request $request)
    {
       
        try {

            $user = Socialite::driver('google')->stateless()->user();
      //return $user->user;
            $finduser = User::where('google_id', $user->user['id'])->first();
            $useremail=User::where('email',$user->user['email'])->first();
      
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            }
            elseif($useremail){
                User::where('email',$user->user['email'])->update(['google_id'=>$user->user['id']]);
                Auth::login($useremail);
                return redirect('/');
            }
            else {
                $users = new User();
                $users->name = $user->user['name'];
                $users->email = $user->user['email'];
                $users->slug = $user->user['name'];
                $users->google_id = $user->user['id'];
                $users->password = encrypt('123456dummy@@');
                $users->email_verified_at = Carbon::now()->timestamp;
                // $users->verification_code = sha1(time());
                $users->is_verified = 1;
                $users->status = 1;
                $users->is_blocked = 1;
                $users->save();
               // return 'fuck';
                $admins = SuperAdmin::whereHas('roles', function ($query) {
                    $query->where('slug', 'admin');
                })->get();
                // dd($admins);
                Notification::send($admins, new NewUserNotification($users));
                Auth::login($users);
                return redirect('/');
            }
        } catch (Exception $e) {
            dd('error');
        }
    }
    public function handleGoogle1Callback(Request $request)
    {
        
        try {
            // return 'name';
            $token = $request->credential;
            $tokenParts = explode(".", $token);
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);
           // return $jwtPayload;
            // $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $jwtPayload->sub)->first();
            $useremail=User::where('email',$jwtPayload->email)->first();
            // return $finduser;
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            }
            elseif($useremail){
                User::where('email',$jwtPayload->email)->update(['google_id'=>$jwtPayload->sub]);
                Auth::login($useremail);
                return redirect('/');
            }
             else {
                $users = new User;
                $users->name = $jwtPayload->name;
                $users->email = $jwtPayload->email;
                $users->slug = $jwtPayload->name;
                $users->google_id = $jwtPayload->sub;
                $users->password = encrypt('123456dummy');
                $users->email_verified_at = Carbon::now()->timestamp;
                $users->verification_code = sha1(time());
                $users->is_verified = 1;
                $users->status = 1;
                $users->is_blocked = 1;
                $users->save();
               
                $admins = SuperAdmin::whereHas('roles', function ($query) {
                    $query->where('slug', 'admin');
                })->get();
                // dd($admins);
                Notification::send($admins, new NewUserNotification($users));
                Auth::login($users);
                return redirect('/');
            }
        } catch (Exception $e) {
            dd('error');
        }
    }
}
