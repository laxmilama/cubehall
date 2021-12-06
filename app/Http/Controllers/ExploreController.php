<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Parlor;
use App\Models\ParlorReview;
use App\Models\ParlorTicket;
use App\Models\ProductList;
use App\Models\User;
use App\Notifications\ReminderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\CurrencyController;
use App\Http\Resources\HistoryProductResources;
use App\Models\History;
use Illuminate\Support\Facades\Cache;

class ExploreController extends Controller
{
    public function __construct(CurrencyController $currencyController)
    {
        $this->CurrencyController = $currencyController;
    }

    public function index()
    {
        // return $this->topStudio();
        // return $this->topParlor();
        // return $this->bestSeller();
        // return $this->trending();


        return view('explore', [
            'studios' => $this->topStudio(),
            'parlors' => $this->topParlor(),
            'products' => $this->bestSeller(),
            'c' => json_encode($this->CurrencyController->getCurrency())
        ]);
    }

    public function topStudio()
    {
        $with_products = Page::whereHas('product', function ($query) {
            $query->whereHas('meta', function ($query) {
                $query->whereHas('sells', function ($sq) {
                    $sq->where('delivery_status', 'DELIVERED')
                        ->where('created_at', '>=', Carbon::now()->subDays(30));
                });
            });
        })
            ->get()
            ->sortByDesc('studio_rating')
            ->sortByDesc('reviews_count');
        // return $with_products;
        if (count($with_products) > 4) {
            return $with_products->paginate(15);
        } else {
            return Page::whereHas('atleastOneProduct', function ($query) {
                $query->where('status', 1)
                    ->whereHas('meta');
            })
                ->orWhereHas('parlors', function ($query) {
                    $query->whereHas('ticket')
                        ->where('status', 1);
                })
                ->get()
                ->sortByDesc('studio_rating')
                ->sortByDesc('reviews_count')
                ->paginate(15);
        }
    }

    public function topParlor()
    {
        $withTicket = Parlor::whereHas('ticket', function ($query) {
            $time = 24 * 30;
            $query->where('created_at', '>=', Carbon::now()->subHours($time));
        })
            ->whereHas('reviews', function ($query) {
                $time = 24 * 30;
                $query->where('created_at', '>=', Carbon::now()->subHours($time));
            })
            ->where('status', 1)
            ->with(['ticket'])
            ->get();

        if (count($withTicket) > 5) {
            return $withTicket
                ->sortByDesc('star_count')
                ->sortByDesc('reviews_count')
                ->paginate(20);
        } else {
            return Parlor::whereHas('ticket')
                ->where('status', 1)
                ->with(['ticket'])
                ->get()
                ->sortByDesc('star_count')
                ->sortByDesc('reviews_count')
                ->paginate(20);
        }
    }

    public function bestSeller()
    {
        $time = 720;

        // return ProductList::whereHas('meta', function($query){
        //     $query->with('sells');
        // })
        //     ->with('meta')
        //     ->where('status', 1)
        //     ->get();

        $withSells =  ProductList::whereHas('meta', function ($query) {
            $query->whereHas('sells', function ($sq) {
                $time = 24 * 30;
                $sq->where('status', 'Delivered')
                    ->where('created_at', '>=', Carbon::now()->subHours($time));
            });
        })
            ->with(['meta' => function ($query) {
                $query->whereHas('sells', function ($sq) {
                    $time = 24 * 30;
                    $sq->where('status', 'Delivered')
                        ->where('created_at', '>=', Carbon::now()->subHours($time));
                });
            }])
            ->where('status', 1)
            ->get();

        if (count($withSells) > 5) {
            return $withSells
                ->sortByDesc('star_count')
                ->sortByDesc('reviews_count')
                ->paginate(20);
        } else {
            return ProductList::whereHas('meta')
                ->where('status', 1)
                ->with(['meta'])
                ->get()
                ->sortByDesc('star_count')
                ->sortByDesc('reviews_count')
                ->paginate(20);
        }

        return $withSells;
    }

    public function trending()
    {

        return HistoryProductResources::collection(Cache::remember('trending_product', 0, function () {
            $date = Carbon::now()->subDays(3);
            return History::select(
                'type',
                'item_id',
                'created_at',
                // DB::raw('count(*) as visits'),
                // (CASE WHEN order_products.status = "Delivered" THEN price END)
                DB::raw('COUNT(CASE WHEN created_at >= "' . $date . '" THEN id END) as visits'),
                DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as my_date")
            )
                ->where('type', 'App\Models\ProductList')
                ->whereHas('product')
                ->groupBy('item_id', DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
                ->distinct()
                ->orderBy('visits', 'desc')
                ->get()
                ->unique('item_id');
        }))->paginate(20);
    }
}
