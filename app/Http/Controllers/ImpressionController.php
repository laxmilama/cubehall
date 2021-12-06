<?php

namespace App\Http\Controllers;

use App\Models\Impression;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ImpressionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->f != csrf_token()) {
            return response()->json([
                'Error' => 'Something went wrong',
            ]);
        } else {
            // dd ($request); // to debug request
            $agent = new Agent();

            $agent->setUserAgent($_SERVER['HTTP_USER_AGENT']);
            // return $agent->platform();
            // return $agent->browser();
            // return $agent->device();
            // dd($request->ip());

            // Checking for device usage;
            if ($agent->isDesktop()) {
                $device = 'Desktop';
            } elseif ($agent->isMobile()) {
                $device = 'Mobile';
            } elseif ($agent->isTablet()) {
                $device = "Tablet";
            } else {
                $device = "Unknown";
            }

            // Platform
            if($agent->platform()){
                $os = $agent->platform();
            }else{
                $os="Unknown";
            }

            foreach ($request->d as $data) {

                $d = parse_url($data);
                parse_str($d['query'], $url);
                $v = base64_decode($url['c']);

                parse_str($v, $i);

                $impression = new Impression;
                $impression->ip = $request->ip();
                $impression->item_id = $i['item'];
                $impression->parent_id = $i['parent']; //owner id
                $impression->type = $i['type'];
                $impression->os = $os;
                $impression->browser = $agent->browser();
                $impression->device = $device;
                $impression->save();
            }
        }
    }
}
