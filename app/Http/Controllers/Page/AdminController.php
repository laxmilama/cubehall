<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use App\Models\Parlor;
use App\Models\ParlorTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function dashboardd()
    {
        return view('page.admin');
    }
    public function admin()
    {
        // return $this->upcomingTickets();
        // return $this->newOrders();

        if (Gate::allows('isPage', Auth::user())) {
            $pages = Auth::user()->pages;
            return view(
                'page.admin',
                [
                    'pages' => $pages,
                    'orders' => $this->newOrders(),
                    'tickets' => $this->upcomingTickets()
                ]
            );
        } else {
            return redirect()->back();
        }
       
    }

    public function newOrders()
    {
        $pages = Auth::user()->pages;
        $page_id = $pages[0]->id;

        return  OrderProduct::where('page_id', $page_id)
            ->where('status', 'New')
            ->latest()
            ->paginate(5);
    }

    public function topProducts()
    {
        $pages = Auth::user()->pages;
        $page_id = $pages[0]->id;        
    }

    public function upcomingTickets()
    {
        $pages = Auth::user()->pages;
        $page_id = $pages[0]->id;

        return Parlor::where('page_id', $page_id)
            ->where('status', 1)
            ->whereHas('tickets', function($query){
                $query->where('time', '>=', Carbon::now())
                ->whereHas('sells');
            })
            ->paginate(10);        
    }
}
