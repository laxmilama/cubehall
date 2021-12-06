<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\Page;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CurrencyController;
use App\Models\Parlor;
use App\Models\ParlorBook;

class FinanceController extends Controller
{
    public function __construct(CurrencyController $currencyController)
    {
        $this->middleware('auth');
        $this->CurrencyController = $currencyController;
    }

    public function index()
    {


        $studio = Auth::user()->pages;

        // return $this->parlorPaid30Days($studio[0]->id);

        // return $this->parlorSellsByMonth($studio[0]->id);
        // $items = [];
        // $startMonth = Carbon::now()->subMonths(11)->format('F Y');
        // $endMonth = Carbon::now()->format('F Y');
        // $monthRange = CarbonPeriod::create($startMonth, '1 month', $endMonth);
        // foreach ($monthRange as $month) {
        //     $items[] = Carbon::parse($month)->format('F Y');
        // }
        // return $items;

        // return $this->shippingByDays30($studio[0]->id);
        // return $this->sellsByMonth($studio[0]->id);
        // return $this->duePayment($studio[0]->id);

        if (Cookie::has('symbol')) {
            $symbol = Cookie::get('symbol');
        } else {
            $symbol = 'Rs';
        }

        if (Cookie::has('currency')) {
            $currency = Cookie::get('currency');
        } else {
            $currency = "NPR";
        }

        $finance = Page::where('page_id', $studio[0]->id)
            ->select(
                'pages.id',
                'pages.name',
                DB::raw('SUM(CASE WHEN order_products.status = "Delivered" THEN price END) as total'),
                DB::raw('SUM(CASE WHEN order_products.status = "Delivered" THEN shipping_charge END) as delivery'),
            )
            ->leftJoin('order_products', 'order_products.page_id', '=', 'pages.id')
            ->groupBy('pages.id', 'pages.name', 'order_products.page_id')
            ->first();

        return view(
            'page.finance',
            [
                'finance' => $finance,
                'product' =>  $this->localCurrency($this->productByDays30($studio[0]->id), $currency),
                'shipping' =>  $this->localCurrency($this->shippingByDays30($studio[0]->id), $currency),
                'associate' => $this->localCurrency(($this->productByDays30($studio[0]->id) / 100) * 15, $currency),
                'due' =>   $this->localCurrency($this->duePayment($studio[0]->id), $currency),
                'analytics' => $this->sellsByMonth($studio[0]->id),
                'symbol' => $symbol,
                'parlor' => $this->parlorEarning($studio[0]->id),
                'parlorpaid' => $this->parlorPaid30Days($studio[0]->id),
                'parloranalytics' => $this->parlorSellsByMonth($studio[0]->id),
            ]
        );
    }

    public function productByDays30($id)
    {
        $product = OrderProduct::whereBetween('paid_at', [now()->subDays(30), now()])
            ->where('page_id', $id)
            ->sum('price');
        return $product;
    }

    public function shippingByDays30($id)
    {
        $product = OrderProduct::whereBetween('paid_at', [now()->subDays(30), now()])
            ->where('page_id', $id)
            ->sum('shipping_charge');
        return $product;
    }

    public function duePayment($id)
    {
        $a = OrderProduct::whereNull('paid_at')
            ->where('status', 'Delivered')
            ->where('page_id', $id)
            ->sum('shipping_charge');
        $b = OrderProduct::whereNull('paid_at')
        ->where('status', 'Delivered')
        ->where('page_id', $id)
        ->sum('price');

        $c = $b - (($b/100)*15);

        return $c + $a;
    }

    public function sellsByMonth($id)
    {

        $an = OrderProduct::where('page_id', $id)
            ->whereBetween('created_at', [now()->subMonths(12), now()])
            ->orderBy('created_at')
            ->select(                
                DB::raw('SUM(price) as total'),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month_year")
            )
            ->groupBy('month_year')
            ->get();



        $items = [];
        $startMonth = Carbon::now()->subMonths(11)->format('F Y');
        $endMonth = Carbon::now()->format('F Y');
        $monthRange = CarbonPeriod::create($startMonth, '1 month', $endMonth);
        foreach ($monthRange as $month) {
            $items[Carbon::parse($month)->format('F Y')] = 0;
        }

        $dbData = [];
        foreach ($an as $key => $value) {
            // return $value->month_year;
            $dbData[$value->month_year] = $value->total;
        }
        $data = array_replace($items, $dbData);

        return json_encode($data);
        return $an;
    }

    function parlorEarning($id)
    {
        $parlors = Parlor::where('page_id', $id)->pluck('id');
        $booking = ParlorBook::whereIn('parlor_id', $parlors)
            ->whereNull('paid_at')
            ->whereNotNull('attended_at')
            // ->whereBetween('created_at', [now()->subDays(30), now()])
            ->sum('total_amount');
        return $booking;
    }

    function parlorPaid30Days($id)
    {
        $parlors = Parlor::where('page_id', $id)->pluck('id');
        $booking = ParlorBook::whereIn('parlor_id', $parlors)
            ->whereNotNull('paid_at')
            ->whereNotNull('attended_at')
            ->sum('total_amount');
        return $booking;
    }

    public function parlorSellsByMonth($id)
    {
        $parlors = Parlor::where('page_id', $id)->pluck('id');
        $booking = ParlorBook::whereIn('parlor_id', $parlors)
            ->whereBetween('created_at', [now()->subMonths(12), now()])
            ->orderBy('created_at')
            ->whereNotNull('paid_at')
            ->whereNotNull('attended_at')
            ->select(
                DB::raw('sum(total_amount) as total'),
                DB::raw("(DATE_FORMAT(created_at, '%M %Y')) as month_year")
            )
            ->groupBy('month_year')
            ->get();


        $items = [];
        $startMonth = Carbon::now()->subMonths(11)->format('F Y');
        $endMonth = Carbon::now()->format('F Y');
        $monthRange = CarbonPeriod::create($startMonth, '1 month', $endMonth);
        foreach ($monthRange as $month) {
            $items[Carbon::parse($month)->format('F Y')] = 0;
        }

        $dbData = [];
        foreach ($booking as $key => $value) {
            // return $value->month_year;
            $dbData[$value->month_year] = $value->total;
        }

        // return $dbData;        

        $data = array_replace($items, $dbData);

        return json_encode($data);

        // return $booking;
    }

    function localCurrency($amount,  $to = 'NPR')
    {
        $from = 'NPR';

        $c = $this->CurrencyController->getCurrency();

        $b = $c->$to;
        $f = $c->$from;
        if ($to != null) {
            if ($from == $to) {
                return $amount;
            } else {
                return ($amount * $b) / $f;
            }
        }
    }
}
