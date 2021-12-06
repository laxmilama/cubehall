<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParlorHistoryResources;
use App\Http\Resources\ProductHistoryResources;
use App\Http\Resources\ShowoffHistoryResources;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parlor;
use App\Models\ProductList;
use App\Models\ShowOff;
use App\Models\History;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $boards =  Board::where('user_id', Auth::user()->id)->latest()->get();

        $types= ['ShowOff', 'ProductList', "Parlor"];

        if (Cookie::has('_uid')) {
            $uid = Cookie::get('_uid');
        } else {
            $now = Carbon::now();
            $rand = mt_rand(1000000, 9999999);
            $u = $now .  $rand;
            $uid = hash('sha256', $u);
            Cookie::queue('_uid', $uid, 2628000);
        }

        if (Auth::check()) {
            $histories = History::select('created_at', 'item_id', 'type', 'id')
            ->where('user_id', Auth::user()->id)
            ->whereIn('type', $types)
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get();
        }

        // return $histories;
        

        

        $combined = collect([]);
        foreach ($histories as $key => $history) {
            // $histories[$key]['data'] = "FUCK";
            // return $histories[$key];
            // return $history;
            if ($history->type == "ShowOff") {
                $p = $history->item_id;
                $showoffs = ShowoffHistoryResources::collection(Cache::remember('History_showoffs', 0, function () use($p) {            
                    return ShowOff::where('id', $p)->latest()->get();
                }));

                // return $showoffs;
                // $combined = $combined->concat($showoffs);

                $histories[$key]['data'] = $showoffs[0];
            }
            if ($history->type == "ProductList") {
                $p = $history->item_id;
                $products = ProductHistoryResources::collection(Cache::remember('History_Products', 0, function () use($p) {         
                    return ProductList::where('id', $p)->latest()->get();
                }));

                $histories[$key]['data'] = $products[0];
            }
            if ($history->type == "Parlor") {
               $p = $history->item_id;
                $parlors = ParlorHistoryResources::collection(Cache::remember('History_parlor', 0, function () use($p) {
                    return Parlor::where('id', $p)->latest()->get();
                }));
                $histories[$key]['data'] = $parlors[0];
            }
        }

        // return $histories;
        // return $combined;
        return view('library', [
            'boards' => $boards,
            'histories' => $histories->unique(),
        ]);
    }
}
