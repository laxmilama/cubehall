<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductReview;
use Auth;


class ProfileController extends Controller
{
    public function orders(){
        $orders=Order::with(['orders'])->where('user_id',Auth::user()->id)->get();
        //dd($orders);
        return view('profile.order',['orders'=>$orders]);
    }
    
    public function ordersDetail(Request $request, $order_id){
        $orderDetails = OrderProduct::with(['product','orderproduct'])->where('order_id',$order_id)->get();
        $reviews=ProductReview::with('orders')->get();
        //dd($reviews);
       // $reviews=ProductReview::get();
        //dd($orderDetails);
        return view('profile.order_detail',['orderDetails'=>$orderDetails,'reviews'=>$reviews]);
    }
    
}
