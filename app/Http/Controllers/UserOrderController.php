<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderPublicResources;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Associate;
use App\Models\Bag;

class UserOrderController extends Controller
{
    public function show()
    {
        return view('order.users');
    }

    public function upcoming()
    {
        $user = Auth::user();
        return Order::where(['user_id' => $user->id])
            ->with('orders')
            ->whereHas('orders', function ($query) {
                $query->where('status', 'New')
                    ->orWhere('status', 'Processing')
                    ->orWhere('status', 'Ready')
                    ->where('delivery_status', "!=", 'DELIVERED');
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function completed()
    {            
        $user = Auth::user();

        //  return Order::where(['user_id'=> $user->id])
        //     ->get();

        return Order::where(['user_id' => $user->id])
            ->with(['orders' => function ($query) {
                $query->with(['review', 'product']);
            }])
            ->whereHas('orders', function ($query) {
                $query->where('delivery_status', 'DELIVERED')
                    ->orWhere('delivery_status', 'CANCELLED');
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
