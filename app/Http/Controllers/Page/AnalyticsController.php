<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductList;
use App\Models\History;
use App\Models\Impression;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AnalyticsController extends Controller
{
    public function show()
    {
        
        $studio = Auth::user()->pages;
        // return $studio;
        // return $this->orders($studio[0]->id);
        return view(
            'page.analytics',
            [
                'totalImpression' => $this->totalImpression($studio[0]->id),
                'uniqueVisitors' => $this->uniqueVisitors($studio[0]->id),
                'totalViews' => $this->totalViews($studio[0]->id),
                'orders' => $this->orders($studio[0]->id),
                'conversionRate' => $this->conversionRate($studio[0]->id),
                'followers' => $this->followers($studio[0]->id)
            ]
        );
    }

    public function impression()
    {
        $studio = Auth::user()->pages;

        $period = CarbonPeriod::create(Carbon::now()->subDays(7), Carbon::now());

        foreach ($period as $date) {
            $range[$date->format('d M')] = 0;
        }

        // return $range;

        if (Gate::allows('isPage', Auth::user())) {

            $days = Impression::where('parent_id', $studio[0]->id)
                ->whereBetween('created_at', [now()->subDays(7), now()])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('d M');
                });

            foreach ($days as $key => $day) {
                $dbData[$key] = count($day);
            }

            $data = array_replace($range, $dbData);

            return json_encode($data);
        }

        return "Bad request format";
    }


    public function totalImpression($studio_id)
    {
        $totalImpressions = Impression::where('type', 'ProductList')
            ->where('parent_id', $studio_id)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get();
        return $totalImpressions->count();
    }

    public function totalViews($studio_id)
    {
        return History::where('parent_id', $studio_id)
            ->whereIn('type', ['ProductList', 'Parlor'])
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get()
            ->count();
    }

    public function uniqueVisitors($studio_id)
    {
        return History::where('parent_id', $studio_id)
            ->whereIn('type', ['ProductList', 'Parlor'])
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('ip')
            ->get()
            ->count();
    }

    public function orders($studio_id)
    {
        return OrderProduct::where('page_id', $studio_id)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get()
            ->count();
    }

    public function followers($studio_id)
    {
        return follow::where('followed_to', $studio_id)
        ->whereBetween('created_at', [now()->subDays(30), now()])
        ->get()
        ->count();
    }

    public function conversionRate($studio_id)
    {
        if($this->orders($studio_id) && $this->uniqueVisitors($studio_id)){
        return round(($this->orders($studio_id) / $this->uniqueVisitors($studio_id)) * 100, 2) . "%";
        }else{
            return "0%";
        }
    }

    /*
    * 7 days data of orders count
    */
    public function ordersByDays()
    {
        $studio = Auth::user()->pages;

        $period = CarbonPeriod::create(Carbon::now()->subDays(7), Carbon::now());

        foreach ($period as $date) {
            $range[$date->format('d M')] = 0;
        }

        $days = OrderProduct::where('page_id', $studio[0]->id)
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d M');
            });
        
            // return $days;
        $dbData=[];

        foreach ($days as $key => $day) {
            $dbData[$key] = count($day);
        }

        $data = array_replace($range, $dbData);

        return json_encode($data);
    }
}
