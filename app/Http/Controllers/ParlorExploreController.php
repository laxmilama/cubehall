<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Parlor;
use App\Models\ParlorSection;
use App\Models\ParlorTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CurrencyController;

class ParlorExploreController extends Controller
{
    public function __construct(CurrencyController $currencyController)
    {
        $this->CurrencyController = $currencyController;
    }

    public function show()
    {
        // return Carbon::now();
        // return $this->newParlors();

        return view('explore.parlors', [
            'histories' => $this->history(),
            'now' => $this->now(),
            'bests' => $this->bestSellers(),
            'news' => $this->newParlors(),
            'current' => Carbon::now(),
            'c' => json_encode($this->CurrencyController->getCurrency()) //currency
        ]);
    }


    public function filtered()
    {
        return view('explore.parlorfilter');
    }

    public function filter(Request $request)
    {
        if ($request->search_type) {
            $request->validate([
                'search_type' => 'required|numeric'
            ]);
            return Parlor::where('theme', $request->search_type)
                ->with('ticket', 'owner')
                ->whereHas('tickets', function ($query) {
                    $query->where('time', '>=', Carbon::now());
                })->paginate(20);
        } else {
            return response('Invalid request.', 400);
        }
    }

    protected function now()
    {
        return Parlor::whereHas('tickets', function ($query) {
            $query->whereBetween('time', [Carbon::now(), Carbon::now()->addHours(8)]);
        })
            ->with(['tickets' => function ($query) {
                $query->whereBetween('time', [Carbon::now(), Carbon::now()->addHours(8)])
                    ->latest();
            }])
            // ->select(['id',])
            ->where('status', 1)
            ->take(20)
            ->get();
    }

    protected function history()
    {
        if (Auth::check()) {

            return History::with(['parlor.ticket' => function ($query) {
                $query->latest();
            }])
                ->whereHas('parlor.tickets')
                ->select(['created_at', 'item_id'])
                ->distinct('item_id')
                ->orderBy('created_at', 'DESC')
                ->where('type', 'Parlor')
                ->groupBy(['item_id'])
                ->where('user_id', Auth::user()->id)
                ->limit(10)
                ->get();
        } else {
            if (Cookie::has('_uid')) {
                return History::with(['parlor.ticket' => function ($query) {
                    $query->latest();
                }])
                    ->whereHas('parlor.tickets')
                    ->select(['created_at', 'item_id'])
                    ->distinct('item_id')
                    ->orderBy('created_at', 'DESC')
                    ->where('type', 'Parlor')
                    ->groupBy(['item_id'])
                    ->where('session_id', Cookie::get('_uid'))
                    ->limit(10)
                    ->get();
            }
        }
        return [];
    }

    protected function bestSellers()
    {
        return Parlor::whereHas('ticket', function ($query) {
            $time = 24 * 30;
            $query->where('time', '>=', Carbon::now()->subHours($time));
        })
            ->whereHas('reviews', function ($query) {
                $time = 24 * 30;
                $query->where('created_at', '>=', Carbon::now()->subHours($time));
            })
            ->with(['ticket'])
            ->where('status', 1)
            ->get()
            ->sortByDesc('star_count')
            ->sortByDesc('reviews_count')
            ->paginate(20);
    }

    protected function allParlors()
    {
        return Parlor::whereHas('tickets', function ($query) {
            $query->where('time', '>=', Carbon::now());
        })
            ->with('ticket', 'owner')
            ->paginate(20);
    }

    protected function newParlors()
    {
        $time = 24 * 30; // this month;
        return Parlor::whereHas('ticket')
            ->with(['tickets' => function ($query) {
                $query->latest()->limit(1);
            },
            'owner'])
            ->select(['id', 'page_id', 'title', 'location', 'languages', 'slug', 'cover'])
            ->where('created_at', '>=', Carbon::now()->subHours($time))
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->take(20)
            ->get();
    }

    protected function getParlors()
    {
        return Parlor::whereHas('tickets', function ($query) {
            $query->where('time', '>=', Carbon::now());
        })
            ->with('tickets')
            ->where('status', 1)
            ->select(['id', 'title', 'location', 'languages', 'slug', 'cover'])
            ->paginate(20);
    }

    public function categoryWithParlors()
    {

        return ParlorSection::with(['categories.parlor'])
            // ->whereHas('categories.parlor', function ($query){
            //     // $query->with('parlor');
            // })
            ->get();
    }
}
