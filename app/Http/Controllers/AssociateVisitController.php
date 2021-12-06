<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\AssociateVisit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AssociateVisitController extends Controller
{
    public function visit($url)
    {
        // Check if associate url exist   
        $a = Associate::with('product')->where('url', $url)->get();

        if (count($a)) {

            if(Auth::check()){
                if(Auth::user()->id == $a[0]->user_id){
                    return redirect()->route('list', [$a[0]->product->slug]);
                    
                }
            }

            // save to database
            $aVisit = new AssociateVisit();
            $aVisit->associate_id = $a[0]->id;
            $aVisit->ip = $_SERVER['REMOTE_ADDR'];
            $aVisit->referral = $_SERVER['HTTP_REFERER'] ?? url()->current();
            $aVisit->save();

            $minutes = 43200; //for 30 days in minute

            $value = Cookie::get('associate');

            

            $d = json_decode($value, true);

            // Remove cookies that are expired
            if ($d != null) {
                foreach ($d as $k => $v) {
                    if (date("Y-m-d") > $v['expires']) {
                        unset($d[$k]);
                    }
                    if($v['url'] == $url){
                        unset($d[$k]);
                    }
                }
            } else {
                $d = [];
            }

            // return $d;

            // add new visit cookie
            $date = new DateTime();
            $date->modify('+30 day');
            $date = $date->format('Y-m-d');            

            $newVisit = ['url' => $url, 'expires' => $date];

            array_push($d, $newVisit);

            // Save cookie
            $cookie = cookie('associate', json_encode($d), $minutes);

            // return $value;

            // Go to product
            return redirect()->route('list', [$a[0]->product->slug])->cookie($cookie);
        }
        abort(404);
    }
}
