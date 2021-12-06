<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use App\Models\History;
use App\Models\ProductList;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Impression;
use App\Models\OrderProduct;
use App\Models\Save;
use App\Models\ShowOffMeta;

class ProductAnalytics extends Controller
{
    public function show(ProductList $product)
    {
        return view('page.product.analytics', [
            'product' => $product,
            'saves' => $this->saved($product->id),
            'tags' => $this->tagged($product->id),
            'associates' => $this->associates($product->id),
            'visits' => $this->visits($product->id),
            'impressions' => $this->impressions($product->id),
            'orders'=> $this->orders($product->id)
        ]);
    }

    public function impressions($id)
    {
        $studio = Auth::user()->pages;

        $period = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());

        foreach ($period as $date) {
            $range[$date->format('d M')] = 0;
        }

        if (Gate::allows('isPage', Auth::user())) {

            $days = Impression::where('item_id', $id)
                ->where('type', 'App\Models\ProductList')
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('d M');
                });

            $dbData = [];
            foreach ($days as $key => $day) {
                $dbData[$key] = count($day);
            }

            $data = array_replace($range, $dbData);

            return json_encode($data);
        }

        return "Bad request format";
    }

    public function visits($id)
    {
        
        $period = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());

        foreach ($period as $date) {
            $range[$date->format('d M')] = 0;
        }

        if (Gate::allows('isPage', Auth::user())) {

            $days = History::where('item_id', $id)
                ->where('type', 'App\Models\ProductList')
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('d M');
                });

            $dbData = [];
            foreach ($days as $key => $day) {
                $dbData[$key] = count($day);
            }


            $data = array_replace($range, $dbData);

            return json_encode($data);
        }

        return "Bad request format";
    }

    // Orders by days
    public function orders($id){

        $period = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());

        foreach ($period as $date) {
            $range[$date->format('d M')] = 0;
        }

        if (Gate::allows('isPage', Auth::user())) {

            $days = OrderProduct::where('product_id', $id)
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('d M');
                });

            $dbData = [];
            foreach ($days as $key => $day) {
                $dbData[$key] = count($day);
            }


            $data = array_replace($range, $dbData);

            return json_encode($data);
        }

        return "Bad request format";

    }

    // Total Tagged in showoffs
    public function tagged($id)
    {
        $tags = ShowOffMeta::where('link_id', $id)
            ->where('type', 'ProductList')
            ->get()
            ->count();
        return $tags;
    }

    // Total saves for this products
    public function saved($id)
    {
        $saves = Save::where('item_id', $id)
            ->where('item_type', 'App\Models\ProductList')
            ->get()
            ->count();
        return $saves;
    }

    // Associates over lifetime
    public function associates($id)
    {
        $associates = Associate::where('product_id', $id)
            ->get()
            ->count();
        return $associates;
    }
}
