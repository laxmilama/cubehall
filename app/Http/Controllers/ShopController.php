<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Page;
use App\Models\ProductList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 
    public function index()
    {
        $combined = collect([]);
        $excludeId = [];
        if (Auth::check()) {
            $histories = History::where('type', 'App\Models\ProductList')
                ->where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'DESC')
                ->with(['product' => function ($query) {
                    $query
                        ->select('id', 'page_id')
                        ->with(['owner' => function ($query) {
                            $query
                                ->whereHas('atleastOneProduct')
                                ->with(['product' => function ($query) {
                                    $query
                                        ->latest()
                                        ->with(['meta' => function ($data) {
                                            $data
                                                ->select('id', 'product_id', 'thumbnail');
                                        }])
                                        ->select('id', 'page_id', 'name');
                                }]);
                        }]);
                }])
                ->select(['item_id', 'created_at'])
                ->whereHas('product')
                // ->distinct('item_id')
                ->groupBy('item_id')
                ->limit(200)
                ->get()
                ->unique('product.owner.id');


            // return $histories;


            // take only stores
            $items = [];
            foreach ($histories as $h) {
                array_push($items, $h->product->owner);
                array_push($excludeId, $h->product->owner->id);
            }


            $combined = $combined->concat($items);
        }

        // return $excludeId;

        $stores =  Page::whereHas('atleastOneProduct')
            ->with(['product' => function ($query) {
                $query
                    ->latest()
                    ->with(['meta' => function ($data) {
                        $data
                            ->select('id', 'product_id', 'thumbnail')->get();
                    }])
                    ->whereHas('meta')
                    ->select('id', 'page_id', 'name')->get();
                // ->limit(4);
            }])
            ->whereNotIn('id', $excludeId)
            ->select('id', 'name', 'slug')
            ->get()
            ->sortByDesc('reviews_count');

        // combine all other pages with recently viewed page;
        $combined = $combined->concat($stores);


        return $combined->paginate(20);
    }

    /*
    Returns to view

    */
    public function show()
    {
        $combined = collect([]);
        if (Auth::check()) {
            $histories = History::select('created_at', 'item_id', 'type')
                ->where('user_id', Auth::user()->id)
                ->where('type', 'App\Models\ProductList')
                ->groupBy('item_id', 'type', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->take(20)
                ->get();

            $histories = $histories->unique('item_id');

            foreach ($histories as $history) {
                $lists = ProductList::with('meta')->where('id', $history->item_id)->get();
                $combined = $combined->concat($lists);
            }
        }
        return view('shop.show', [
            'RecentlyViewedProducts' => $combined,
        ]);
    }
}
