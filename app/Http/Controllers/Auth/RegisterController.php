<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SuperAdmin;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\MailController;
use App\Notifications\UserVerficationNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 
            array(
                'required',
                'regex:/(^[A-Za-z]{3,16})([ ]{0,1})([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})/'
            ),
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {
        $request->validate([
            'name' => 
            array(
                'required',
                'regex:/(^[A-Za-z]{3,16})([ ]{0,1})([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})/'
            ),
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
      $users=User::where('email',$request->email)->first();
    //   if($users){
    //       return redirect()->back()->withErrors(
    //         [
    //             'email' => 'Email already!'
    //         ]);
    //   }
    //   else{
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->slug = $request->name;
        $user->password = Hash::make($request->password);
        $user->verification_code=sha1(time());
        $user->status=1;
        $user->is_blocked = 1;
        $user->save();
       
       
        $admins = SuperAdmin::whereHas('roles', function ($query) {
            $query->where('slug', 'admin');
            })->get();
            // dd($admins);
            Notification::send($admins, new NewUserNotification($user));
            if($user!=null){
            //send Email
            //send verification email
            Notification::send($user, new UserVerficationNotification($user));
           // MailController::sendSignupEmail($user->name,$user->email,$user->verification_code);

            return redirect()->route('login')->with('success', 'To login, please check your email for email verification.');
            }
       // }
            // return $user;
            // return User::create([
            // 'name' => $data['name'],
            // 'email' => $data['email'],
            // 'password' => Hash::make($data['password']),
            // ]);
            }

            public function verifyUser(Request $request){
                $verification_code = \Illuminate\Support\Facades\Request::get('code');
                $user = User::where(['verification_code' => $verification_code])->first();
                    if($user != null){
                        $user->is_verified = 1;
                        $user->email_verified_at = Carbon::now()->timestamp;;
                        $user->save();
                        return redirect()->route('login')->with('success', 'Your account is verified. Please login!');
                    }
                return redirect()->route('login')->with('error', 'Invalid verification code!');
             }
      
}
