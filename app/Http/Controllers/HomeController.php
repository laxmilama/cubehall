<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\ShowOff;
use App\Models\History;
use App\Models\Parlor;
use App\Models\ParlorTicket;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $productlist = ProductList::orderBy('id', 'DESC')->where('status', 1)->paginate(20);

        return view('home', ['productlist' => $productlist]);
    }

    public function show()
    {
        // return please;
        $section = Section::with(['categories' => function ($query) {
            $query->with(['subcategories' => function ($q) {
                $q->whereHas('product');
            }]);

            $query->whereHas('subcategories', function ($q) {
                $q->whereHas('product');
            });
        }])
            ->whereHas('categories', function ($query) {
                    $query->whereHas('subcategories', function($p){
                        $p->whereHas('product');
                    });
            })
            ->get();

        // History for User
        $combined = collect([]);
        if (Auth::check()) {
            $histories = History::select('created_at', 'item_id', 'type')
                ->where('user_id', Auth::user()->id)
                ->where('type', 'App\Models\ProductList')
                ->groupBy('item_id', 'type', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->take(50)
                ->get();
        } else {
            if (Cookie::has('_uid')) {
                $uid = Cookie::get('_uid');
            } else {
                $now = Carbon::now();
                $rand = mt_rand(1000000, 9999999);
                $u = $now .  $rand;
                $uid = hash('sha256', $u);
    
                // set cookie
                Cookie::queue('_uid', $uid, 2628000);
            }
            $histories = History::select('created_at', 'item_id', 'type')
                ->where('session_id', $uid)
                ->where('type', 'App\Models\ProductList')
                ->groupBy('item_id', 'type', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->take(50)
                ->get();
        }

        $histories = $histories->unique('item_id');



        foreach ($histories as $history) {
            $lists = ProductList::with('meta')->where('id', $history->item_id)->get();
            $combined = $combined->concat($lists);
        }


        return view('home', [
            'RecentlyViewedProducts' => $combined,
            'category' => $section,
        ]);
    }

    public function showoff()
    {
        $showoff = ShowOff::with('owner')->whereHas('tagged')->latest()->paginate(12);
        return response()->json($showoff);
    }
}
