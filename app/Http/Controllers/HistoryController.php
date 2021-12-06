<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParlorHistoryResources;
use App\Http\Resources\ProductHistoryResources;
use App\Http\Resources\ShowoffHistoryResources;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parlor;
use App\Models\ProductList;
use App\Models\ShowOff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Session;
class HistoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types= ['App\Models\ShowOff', 'App\Models\ProductList', "App\Models\Parlor"];

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
            ->groupBy('item_id', 'type', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->distinct('item_id')
            ->limit(500)
            ->get();
        } else {
            if (Cookie::has('_uid')) {
                $histories = History::select('created_at', 'item_id', 'type', 'id')
                ->where('session_id', $uid)
                ->whereIn('type', $types)
                ->groupBy('item_id', 'type', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->distinct('item_id')
                ->limit(500)
                ->get();
            }
        }
        

        

        // $combined = collect([]);
        foreach ($histories as $key => $history) {
            // $histories[$key]['data'] = "FUCK";
            // return $histories[$key];
            // return $history;
            if ($history->type == "App\Models\ShowOff") {
                $p = $history->item_id;
                $showoffs = ShowoffHistoryResources::collection(Cache::remember('History_showoffs', 0, function () use($p) {            
                    return ShowOff::where('id', $p)->latest()->get();
                }));

                // return $showoffs;
                // $combined = $combined->concat($showoffs);

                $histories[$key]['data'] = $showoffs[0];
            }
            if ($history->type == "App\Models\ProductList") {
                $p = $history->item_id;
                $products = ProductHistoryResources::collection(Cache::remember('History_Products', 0, function () use($p) {         
                    return ProductList::where('id', $p)->latest()->get();
                }));

                $histories[$key]['data'] = $products[0];
            }
            if ($history->type == "App\Models\Parlor") {
               $p = $history->item_id;
                $parlors = ParlorHistoryResources::collection(Cache::remember('History_parlor', 0, function () use($p) {
                    return Parlor::where('id', $p)->latest()->get();
                }));
                $histories[$key]['data'] = $parlors[0];
            }
        }
        return $histories->paginate(15);
    }

    public function show(){
        return view('history.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($itemId, $type, $parentId)
    {       

        $history = new History();

        if (Auth::check()) {
            $history->user_id = Auth::user()->id;
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
            $history->session_id = $uid;
        }

        $history->item_id = $itemId;
        $history->parent_id = $parentId;
        $history->type = $type;
        $history->referrer = $_SERVER['HTTP_REFERER'] ?? url()->current();
        $history->ip = $_SERVER['REMOTE_ADDR'];
        $history->save();

        return response()->json(['success' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        if ($history->user_id == Auth::user()->id) {
            // Delete 
            $history->delete();
        }

        return $history->id;
    }

    public function clearHistory(){
        if(Auth::check()){
            History::where('user_id', Auth::user()->id)->delete();
        }else{
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

            History::where('session_id', $uid)->delete();

        }
    }

}
