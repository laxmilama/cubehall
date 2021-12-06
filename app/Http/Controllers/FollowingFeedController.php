<?php

namespace App\Http\Controllers;

use App\Helpers\General\CollectionHelper;
use App\Models\follow;
use App\Models\FollowUser;
use App\Models\Page;
use App\Models\Parlor;
use App\Models\ProductList;
use App\Models\ShowOff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowingFeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getFollowingFeed(Request $request)
    {
       
        $combined = collect([]);

        $following = follow::where('followed_by', Auth::user()->id)->pluck('followed_to');

        if ($request->get('type') == "product") {
            $products = ProductList::whereIn('page_id', $following)
            ->with(['owner', 'meta'])
            ->where('status', 1)
            ->latest()->get();
            $combined = $combined->concat($products);
        } elseif ($request->get('type') == "parlor") {
            // return $following;
            $parlors = Parlor::whereIn('page_id', $following)
            ->whereHas('ticket')
            ->with(['owner', 'ticket'])
            ->where('status', 1)
            ->latest()
            ->get();
            $combined = $combined->concat($parlors);
        } elseif ($request->get('type') == "showoff") {
            $user = FollowUser::where('followed_by', Auth::user()->id)->pluck('followed_to');
            $showoff = ShowOff::whereIn('user_id', $user)->with('owner')->whereHas('tagged')->latest()->get();
            $combined = $combined->concat($showoff);
        } else {
            $products = ProductList::whereIn('page_id', $following)
            ->with(['owner', 'meta'])
            ->where('status', 1)
            ->latest()
            ->get();

            $parlors = Parlor::whereIn('page_id', $following)
            ->whereHas('ticket')
            ->with(['owner', 'ticket'])
            ->where('status', 1)
            ->latest()
            ->get();

            $combined = $products->concat($parlors)->sortBy([
                ['created_at', 'desc'],
            ]);

            $user = FollowUser::where('followed_by', Auth::user()->id)->pluck('followed_to');

            $showoff = ShowOff::whereIn('user_id', $user)->with('owner')->latest()->get();

            $combined = $combined->concat($showoff)->sortBy([
                ['created_at', 'desc'],
            ]);
        }

        

        return collect($combined->sortBy([
            ['created_at', 'desc'],
        ]))->paginate(15);
    }



    public function getProductsFeed()
    {

        $following = follow::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $products = ProductList::whereIn('page_id', $following)->with('owner')->latest()->where('status', 1)->get();

        $parlors = Parlor::whereIn('page_id', $following)->with('owner')->latest()->get();


        // Combine an sort

        $combined = $products->concat($parlors)->sortBy([
            ['created_at', 'desc'],
        ]);

        $user = FollowUser::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $showoff = ShowOff::whereIn('user_id', $user)->with('owner')->whereHas('tagged')->latest()->get();

        $combined = $combined->concat($showoff)->sortBy([
            ['created_at', 'desc'],
        ]);

        // return CollectionHelper::paginate($combined, 5);

        // return $combined;

        return view('following', [
            'items' => $combined,
            'following' => $this->followingCreators(),
        ]);
    }

    public function followingCreators()
    {
        $following = follow::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $studios = Page::whereIn('id', $following)->latest()->get();

        // return $studios;

        $followinguser = FollowUser::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $users = User::whereIn('id', $followinguser)->latest()->get();

        $combined = $users->merge($studios)->sortBy([
            ['created_at', 'desc'],
        ]);

        return $combined;
    }

    public function Products()
    {
        $following = follow::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $products = ProductList::whereIn('page_id', $following)
            ->with('owner')
            ->where('status', 1)
            ->latest()->get();


        // return $products;
        return view('following', [
            'items' => $products,
            'following' => $this->followingCreators(),
        ]);
    }

    public function Parlors()
    {
        $following = follow::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $parlor = Parlor::whereIn('page_id', $following)
        ->with(['owner', 'ticket'])
        ->where('status', 1)
        ->latest()
        ->get();


        return view('following', [
            'items' => $parlor,
            'following' => $this->followingCreators(),
        ]);
    }

    public function Showoffs()
    {

        $user = FollowUser::where('followed_by', Auth::user()->id)->pluck('followed_to');

        $showoff = ShowOff::whereIn('user_id', $user)->with('owner')->latest()->get();

        // return $showoff;

        return view('following', [
            'items' => $showoff,
            'following' => $this->followingCreators(),
        ]);
    }

    // 
    public function user(User $user)
    {
        $user = ShowOff::where('user_id', $user->id)->with('owner')->latest()->get();

        return view('following', [
            'items' => $user,
            'following' => $this->followingCreators(),
        ]);
    }

    public function studio(Page $studio)
    {
        $parlor = Parlor::where('page_id', $studio->id)->latest()->get();
        $products = ProductList::where('page_id', $studio->id)->latest()->get();

        $combined = $products->concat($parlor)->sortBy([
            ['created_at', 'desc'],
        ]);

        return view('following', [
            'items' => $combined,
            'following' => $this->followingCreators(),
        ]);
    }
}
