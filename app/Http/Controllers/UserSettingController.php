<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSettingResources;
use App\Models\Currency;
use App\Models\User;
use App\Models\UserCurriency;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    public function showSettings()
    {
        return view('settings.user.show');
    }

    public function security(){         
        $id = Auth::user()->id;
        $user =  new UserSettingResources(User::findOrFail($id));
        // return $user;
        return view('settings.user.security', [
            'person' => json_encode($user)
        ]);
    }

    public function changePassword(Request $request){
        
        $request->validate([
            'oldPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'confirmPassword' => ['same:newPassword'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);

        return "Success";
    }
    public function currency(Request $request){
       
       return view('settings.user.currency'); 
    }

    public function saveCurrency(Request $request)
    {      
      $data=$request->all();   
      $currency=$data['currency'];
      $symbol=Currency::where('currency_code',$currency)->pluck('symbol')->first();
      //return $symbol;
   
      
      if(Auth::check())
      { 
        $userCurrencyCount=UserCurriency::where('user_id',Auth::user()->id)->count();
        $userCurrency=new UserCurriency;

          if($userCurrencyCount>0){
        
              UserCurriency::where('user_id',Auth::user()->id)->update(['currency_code'=>$data['currency'],'symbol'=>$symbol]);
          }
          else{
        $userCurrency->user_id=Auth::user()->id;
        $userCurrency->currency_code=$data['currency'];
        $userCurrency->symbol=$symbol;
        $userCurrency->status=1;
        $userCurrency->save();
          }
     }
    
     Cookie::queue(Cookie::forever('symbol',$symbol));
     return back()->withCookie(cookie()->forever('currency', $currency));  
    
  }
}
