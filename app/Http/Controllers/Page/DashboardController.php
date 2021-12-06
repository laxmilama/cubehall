<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use App\Models\ProductList;
use App\Models\User;
use App\Models\StudioColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        
        $period = CarbonPeriod::create(Carbon::now()->subDays(7), Carbon::now());

        foreach($period as $date){
            $range[$date->format('d M')] = 0;
        }

        if(Gate::allows('isPage',Auth::user())) {
            $studio=Auth::user()->pages;

            $productIds = ProductList::where("page_id", $studio[0]->id)->get()->pluck('id');

            $days = History::whereIn('item_id', $productIds)
            ->where('type', 'ProductList')
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
            return $data;
        }

        return "error: 500";         
    }
}