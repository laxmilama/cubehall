<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CurrencyController;
use App\Models\AssociatePaid;
use App\Models\ShowOffEarn;
use Carbon\Carbon;
use Cookie;

class AssociateController extends Controller
{
    protected $CurrencyController;

    public function __construct(CurrencyController $currencyController)
    {
        $this->middleware('auth');
        $this->CurrencyController = $currencyController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(Auth::id());
        // $a = Associate::where('user_id', Auth::id())->get();
        // $user = User::where('id', Auth::id())->first();
        // $user = Auth::id();
        // // dd($user);
        // $associate = User::with('associates');
        // return $associate->get();
        // $associate->where('user_id', $user);
        $associate = Associate::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        return $associate;
        // dd($a);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request

        $a = Associate::where('user_id', Auth::user()->id)->where('product_id', $request->listid)->first();

        // return $a;
        if ($a) {
            return response()->json(['url' => $a->url]);
        }

        $associate = new Associate;
        $associate->user_id = Auth::user()->id;
        $associate->owner_id = $request->ownerid;
        $associate->product_id = $request->listid;
        $associate->url = $this->generateUrl();
        $associate->save();

        // save associate paid for the first time
        // return 'fuck';
        $ap = AssociatePaid::where('user_id', Auth::user()->id)->first();
        // return $ap;
        if (!$ap) {
            // return 'FUCK';
            $paid = new AssociatePaid;
            $paid->user_id = Auth::user()->id;
            $paid->last_paid = Carbon::now();
            $paid->amount = 0;
            $paid->currency = "NPR";
            $paid->save();

            // return $paid;
        }

        return response()->json(['url' => $associate->url]);
    }

    public function generateUrl()
    {

        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $base  = strlen($characters) - 1;
        $output = "";
        $len = 12;
        for ($i = 0; $i < $len; $i++) {
            $output = $output . $characters[mt_rand(0, $base)];
        }

        // $url = Associate::where('url', $output)->get();
        // if($url){
        //     return $this->generateUrl();
        // }
        // $output = "falano";

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function show(Associate $associate)
    {

        $associate = Associate::with([
            'product' => function ($query) {
                $query->select(['id', 'user_id', 'name'])
                    ->with(['meta' => function ($query) {
                        $query->select(['id', 'product_id', 'thumbnail']);
                    }]);
            },
            'owner' => function ($query) {
                $query->select(['id', 'name', 'slug']);
            },
            'sells' => function ($query) {
                $query->where('status', 0);
            }
        ])
            ->orderBy('created_at', 'DESC')
            ->where('user_id', Auth::id())
            ->get();
        // return $associate;

        $total = 0;

        $ascEarn = Associate::with([
            'sells' => function ($query) {
                $query->where('status', 0);
            }
        ])
            ->orderBy('created_at', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->get();
        // return $ascEarn;
        foreach ($ascEarn as $a) {
            foreach ($a->sells as $sell) {
               // return $sell;
                $total = $total + $this->localPrice($sell->amount, $sell->currency);
            }
        }

        // return $total;

        $showoffs = ShowOffEarn::where('status', 0)
            ->where('user_id', Auth::user()->id)
            ->get();

        $showoffTotal = 0;
        foreach ($showoffs as $earning) {
            // return $sell;
            $showoffTotal = $showoffTotal + $this->localPrice($earning->amount, $earning->currency);
        }

        $total =  $total + $showoffTotal;

        // return $showoffTotal;

        $transactions = AssociatePaid::where('user_id', Auth::user()->id)
            ->where('amount', '>', 0)
            ->paginate(15);


        return view('associate.show', [
            'associates' => $associate,
            'total' => $total,
            'transactions' => $transactions
        ]);
    }

    function localPrice($amount, $from = 'NPR')
    {

        $c = $this->CurrencyController->getCurrency();

        // return $c;
        $a = Cookie::get('currency');

        $b = $c->$a;
        $f = $c->$from;
        // return $f;
        if (Cookie::get('currency') != null) {
            if ($from == Cookie::get('currency')) {
                return $amount;
            } else {
                return ($amount * $b) / $f;
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function edit(Associate $associate)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Associate $associate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Associate $associate)
    {
        //
    }
}
