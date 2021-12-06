<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Mail\Mailer;
use App\Mail\OrderStatusMail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\OrderStatusNotification;
use Auth;

class OrderController extends Controller
{

    public function order()
    {
        $pages = Auth::user()->pages;
        // dd($pages);
        // foreach($pages as $page){
        //     $page_id=$page['id'];
        // }
        $page_id = $pages[0]->id;
        $orders = OrderProduct::with(['orderproduct', 'product.productmeta'])->latest()->where('page_id', $page_id)->get();

        // return $orders;

        return view('order.order', ['orders' => $orders]);
    }

    public function orderDetails(Request $request, $id)
    {
        //  $orders=Order::with(['orders.product.metas','deliveryaddress','customers'])->where('id',$id)->first();
        $orders = OrderProduct::with(['orderproduct', 'customers', 'product.productmeta'])->where('id', $id)->firstOrFail();

        //  return $orders;
        return view('order.order_details', ['orders' => $orders]);
    }

    public function orderStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            if($request->order_status == 'Ready'){
             
                // pickup_date
                // message
                OrderProduct::where('id', $data['id'])->update(['status' => $data['order_status'],'pickup_at'=>$data['pickup_date'],'pickup_note'=>$data['message']]);

            }
            else{
            OrderProduct::where('id', $data['id'])->update(['status' => $data['order_status']]);

            $orderstatus = OrderProduct::with(['customers', 'studioes.users', 'orderproduct'])->where('id', $data['id'])->first();
            // return $orderstatus;
            // $name = $orderstatus->customers->name;

            // $user_email =  $orderstatus->customers->email;

            // $studio_name = $orderstatus->studioes->name;

            foreach ($orderstatus->studioes->users as $st) {

                $studio_email = $st->email;
                // dd($studio_email);  
            }
           // $status = $orderstatus->status;
             $orderstatus->customers->notify(new OrderStatusNotification($orderstatus));
            // dd($status);
            // MailController::sendMail($name, $user_email, $studio_name, $studio_email, $status);
        }
            return redirect()->back()->with('success_message', 'Succesfull');
        }
    }
}
