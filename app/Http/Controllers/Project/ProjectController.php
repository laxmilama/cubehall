<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use View;
use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\ProductMeta;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Bag;
use App\Models\Page;
use App\Models\SuperAdmin;
use App\Notifications\NewOrderNotification;
use App\Models\ProductReview;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Coupon;
use App\Models\User;
use Session;
use Auth;
use DB;
use Illuminate\Support\Facades\Cookie;

class ProjectController extends Controller
{
    public function productDetail(ProductList $product_detail)
    {
        //$product_detail=ProductList::with(['metas'])->get();
        dd($product_detail);
        return view('project.product_details', ['product_detail' => $product_detail]);
    }
    //get product size wise price 
    public function productPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            if ($data['colorhex'] != null) {
                $getPrice = ProductMeta::where(['product_id' => $data['product_id'], 'colorhex' => $data['colorhex']])->first();
                // dd($getPrice);
                $getCurrency = ProductMeta::getCurrency($getPrice->price);
            }
            //dd($getPrice);
            if ($data['material'] != null) {
                $getPrice = ProductMeta::where(['product_id' => $data['product_id'], 'material' => $data['material']])->first();
                //dd($getPrice);
                $getCurrency = ProductMeta::getCurrency($getPrice->price);
            }
            if ($data['size'] != null) {
                $getPrice = ProductMeta::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first();
                $getCurrency = ProductMeta::getCurrency($getPrice->price);
            }
            //    $getCurrency=ProductList::getCurrency($getPrice->price);
            //dd($getCurrency);
            //   $currency= Cookie::get('currency');
            //  dd($currency);
            //     if($currency == 'NRS'){
            //         return "Rs ".$getPrice->price;
            //     }
            //     elseif($currency == 'USD'){
            //         return "USD ".$getCurrency['USD_Rate'];
            //     }
            //     elseif($currency == 'EURO'){
            //        return "EURO ".$getCurrency['EURO_Rate'];
            //     }
            //     elseif($currency == 'YEN'){
            //         return "YEN ".$getCurrency['YEN_Rate'];
            //     }
            //     elseif($currency == 'INR'){
            //        return "INR ".$getCurrency['INR_Rate'];
            //     }
            return $getPrice->price . "," . $getCurrency['USD_Rate'] . "," . $getCurrency['EURO_Rate'] . "," . $getCurrency['YEN_Rate']
                . "," . $getCurrency['INR_Rate'];
        }
    }
    public function bag()
    {        
        // return Cookie::get('associate');
        $userBagItems = Bag::userBagItems();
        // return $userBagItems;
        
        return view('bag.bag', ['userBagItems' => $userBagItems]);
    }

    //add to bag
    public function addtoBag(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            $name = ProductMeta::with(['productmeta'])->where('id', $data['product_id'])->first();
            // dd($name); 
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }
            if ($data['size'] == null || $data['material'] == null || $data['color'] == null) {
                // dd($data);
                //check if product is already added to cart
                if (Auth::check()) {
                    //user is logged in
                    $countProducts = Bag::where([
                        'productmeta_id' => $data['product_id'],
                        'user_id' => Auth::user()->id
                    ])->count();
                } else {
                    $countProducts = Bag::where([
                        'productmeta_id' => $data['product_id'],
                        'session_id' => Session::get('session_id')
                    ])->count();
                }
                if ($countProducts > 0) {
                    $message = "Product already added to bag";
                    return redirect()->back()->with('error_message', $message);
                }
                //dd($countProducts);
                $bag = new Bag;
                $bag->session_id = $session_id;
                if (Auth::check()) {
                    $bag->user_id = Auth::user()->id;
                }
                $bag->productmeta_id = $data['product_id'];
                $bag->page_id = $data['page_id'];
                $bag->quantity = 1;
                //dd($bag);
                $bag->save();

                $message = "product has been addded to cart";
                return redirect('/bag')->with('success_message', $message);
            } else {

                //check if product is already added to cart
                if (Auth::check()) {
                    //user is logged in
                    // dd($data);
                    if ($data['size'] != null) {
                        $countProducts = Bag::where([
                            'productmeta_id' => $data['product_id'], 'size' => $data['size'],
                            'user_id' => Auth::user()->id
                        ])->count();
                    } else if ($data['material'] != null) {
                        $countProducts = Bag::where([
                            'productmeta_id' => $data['product_id'], 'material' => $data['material'],
                            'user_id' => Auth::user()->id
                        ])->count();
                    } else if ($data['colorhex'] != null) {
                        $countProducts = Bag::where([
                            'productmeta_id' => $data['product_id'], 'colorhex' => $data['colorhex'],
                            'user_id' => Auth::user()->id
                        ])->count();
                    }
                } else {
                    $countProducts = Bag::where([
                        'productmeta_id' => $data['product_id'], 'size' => $data['size'],
                        'session_id' => Session::get('session_id')
                    ])->count();
                }
                if ($countProducts > 0) {
                    $message = "Product already added to bag";
                    return redirect()->back()->with('error_message', $message);
                }
                // dd($data);
                $bag = new Bag;
                $bag->session_id = $session_id;
                $bag->productmeta_id = $data['product_id'];
                if (Auth::check()) {
                    $bag->user_id = Auth::user()->id;
                }

                // if($data['material'] != null && $data['size'] != null){ 
                if ($data['material'] != null) {
                    $bag->material = $data['material'];
                    $bag->size = $data['size'];
                    $bag->color = $data['colorhex'];
                }
                // else if($data['material'] != null && $data['colorhex'] != null){ 
                else if ($data['size'] != null) {
                    $bag->color = $data['colorhex'];
                    $bag->material = $data['material'];
                    $bag->size = $data['size'];
                }

                // else if($data['size'] != null && $data['colorhex'] != null)
                else if ($data['colorhex'] != null) {
                    $bag->size = $data['size'];
                    $bag->color = $data['colorhex'];
                    $bag->material = $data['material'];
                }
                $bag->page_id = $data['page_id'];
                $bag->quantity = 1;
                //dd($bag);
                $bag->save();
                $message = "painting has been addded to cart";
                return redirect('/bag')->with('success_message', $message);
            }
        }
    }
    //update quantity of the product
    public function productQuantity(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            //get available stock
            $bagDetail = Bag::find($data['bagid']);
            $getStock = ProductMeta::select('stock')->where([
                'product_id' => $bagDetail['product_id'],
                'size' => $bagDetail['size']
            ])->first()->toArray();
            // dd($getStock['stock']);
            //check if stock is available or not
            if ($data['quantity'] > $getStock['stock']) {
                $userBagItems = Bag::userBagItems();
                return response()->json([
                    'status' => false,
                    'message' => "Requested stock in not available",
                    'view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])
                ]);
            }
            //check product size is available or not
            $getSize = ProductMeta::select('size')->where([
                'product_id' => $bagDetail['product_id'],
                'size' => $bagDetail['size']
            ])->count();
            if ($getSize == 0) {
                $userBagItems = Bag::userBagItems();
                return response()->json([
                    'status' => false,
                    'message' => "Requested size is not available",
                    'view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])
                ]);
            }
            Bag::where('id', $data['bagid'])->update(['quantity' => $data['quantity']]);
            $userBagItems = Bag::userBagItems();
            //($userBagItems);
            return response()->json(['view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])]);
        }
    }
    //delete bag product
    public function productBagDelete(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //dd($data);
            Bag::where('id', $data['bagid'])->delete();
            $userBagItems = Bag::userBagItems();
            return response()->json([
                'view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])
            ]);
        }
    }


    //checkout
    public function checkout(Request $request)
    {
        // $userBagItems=Bag::userBagItems();
        // dd($request->all());
        $deliveryDetails = DeliveryAddress::where('user_id', Auth::user()->id)->first();
        //dd($deliveryDetails);
        $bags = Bag::with(['bagmetaproduct.productmeta'])->where('user_id', Auth::user()->id)->first();
        //dd($bags);
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            //  $deliveryDetails = DeliveryAddress::where('user_id',Auth::user()->id)->first();
            // $bags = Bag::with(['bagproduct'])->where('user_id',Auth::user()->id)->first();
            if (Auth::check()) {

                $deliveryCount = DeliveryAddress::where('user_id', Auth::user()->id)->count();
                $deliveryDetails = array();
                if ($deliveryCount > 0) {
                    $deliveryDetails = DeliveryAddress::where('user_id', Auth::user()->id)->first();
                }
                if ($deliveryCount > 0) {
                    //update delivery Address
                    DeliveryAddress::where('user_id', Auth::user()->id)->update([
                        'name' => $data['name'],
                        'address' => $data['address'],
                        'city' => $data['city'], 'province' => $data['province'], 'landmark' => $data['landmark'],
                        'country' => $data['country']
                    ]);
                } else {
                    //New delivery Address
                    $delivery = new DeliveryAddress;
                    $delivery->user_id = Auth::user()->id;
                    $delivery->user_email = Auth::user()->email;
                    $delivery->name = $data['name'];
                    $delivery->address = $data['address'];
                    $delivery->city = $data['city'];
                    $delivery->province = $data['province'];
                    $delivery->country = $data['country'];
                    $delivery->landmark = $data['landmark'];

                    $delivery->save();
                }
            } else {
                return redirect()->route('/login');
            }
        }
        $userBagItems = Bag::userBagItems();
        return view('project.checkout', ['userBagItems' => $userBagItems, 'deliveryDetails' => $deliveryDetails, 'bags' => $bags]);
    }
    public function verification(Request $request)
    {
        //dd($request->all());
        $am  = $request->input('amount');
        $amou = $am / 100;
        //dd($amou);
        //hit the khalit server
        $args = http_build_query(array(
            'token' => $request->input('trans_token'),
            'amount'  => $request->input('amount')
        ));

        $url = "https://khalti.com/api/v2/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key test_secret_key_4ec675868b2b4cd4b32528a81e931c2d'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        // dd($response); //see the response from khalti server
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $res = json_decode($response, true); //decode the response
        if (isset($res['idx']))  //check whether there is idx and also the amount in response with your database(I havenot done that)
        {
            //perform your database operation here,,,

            $deliveryDetails = DeliveryAddress::where(['user_email' => Auth::user()->email])->first();
            //    $bagProduct = Bag::where(['user_id'=>Auth::user()->id])->first();
            // dd($bagProduct);
            // $userBagItems=Bag::userBagItems();

            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->delivery_id = $deliveryDetails['id'];
            $order->order_status = "New";

            $order->payment = "Done";
            $order->total_amount = $amou;
            // dd($order);
            $order->save();

            $order_id = DB::getPdo()->lastinsertID();

            $bagProducts = DB::table('bags')->where(['user_id' => Auth::user()->id])->get();
            // dd($bagProducts);
            foreach ($bagProducts as $pro) {
                $bagPro = new OrderProduct;
                $bagPro->order_id = $order_id;
                $bagPro->user_id = Auth::user()->id;
                $bagPro->productmeta_id = $pro->productmeta_id;
                $bagPro->page_id = $pro->page_id;
                $bagPro->quantity = $pro->quantity;
                $bagPro->size = $pro->size;
                $bagPro->material = $pro->material;
                $bagPro->color = $pro->color;
                $bagPro->save();

                $admins = SuperAdmin::whereHas('roles', function ($query) {
                    $query->where('id', 5);
                })->get();
                // $studioes = Page::whereHas('pageroles', function ($query) {
                //     $query->where('id', 5);
                // })->get();

                $studioes = Page::with(['pageroles' => function ($query) {
                    $query->where('slug', '=', 'admin');
                }])->where('id', '=', $pro->page_id)->get();

                // dd($studioes);
                foreach ($admins as $ad) {
                    $ad->notify(new NewOrderNotification($bagPro));
                }
                foreach ($studioes as $su) {
                    $su->notify(new NewOrderNotification($bagPro));
                }
            }
            //    if($order->payment="Done"){
            //     return redirect('/thanks');
            // }

            return response()->json([  //returns success to ajax
                'success' => 'Your Account is succesfully credited.',
            ], 200);
        } else {

            return response()->json([ //returns failure to ajax
                'error' => 'Something went Wrong.',
            ], 404);
        }
    }
    //delete bag items
    public function thanks(Request $request)
    {
        DB::table('bags')->where('user_id', Auth::user()->id)->delete();
        return view('project.thanks');
    }
    //apply coupon/gift code
    public function applyCouponCode(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->coupon_code);
            $couponCount = Coupon::where('coupon_code', $request->coupon_code)->count();
            //dd($couponCount);
            if ($couponCount == 0) {
                $userBagItems = Bag::userBagItems();
                // dd($userBagItems);
                return response()->json([
                    'status' => false,
                    'message' => 'The entered code cannot be applied, because it does not meet the requirements.',
                    'view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])
                ]);
            } else {
                //check other coupon conditions
                //get coupon details
                $couponDetails = Coupon::where('coupon_code', $request->coupon_code)->first();
                //check if coupon is active or inactive
                if ($couponDetails->status == 0) {
                    $message = "This coupon is not active";
                }
                //check if coupon is expired
                $expiry_date = $couponDetails->expiry_date;
                $currenct_date = date('Y-m-d');
                if ($expiry_date < $currenct_date) {
                    $message = "The coupon is expired";
                }
                //get all selected category form coupon
                $categoryAttr = explode(",", $couponDetails->categories);
                $userBagItems = Bag::userBagItems();
                //get all selected user of coupon
                if (!empty($couponDetails->users)) {
                    $userAttr = explode(",", $couponDetails->users);
                    //get user if of seleted user coupon
                    foreach ($userAttr as $key => $user) {
                        $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                        $userId[] = $getUserId['id'];
                    }
                }
                $totalPrice = 0;
                $cookieValue = $request->cookie('currency');
                foreach ($userBagItems as $key => $item) {
                    //check if any items belongs to coupon category
                    if (!in_array($item['bagproduct']['page_category_id'], $categoryAttr)) {
                        $message = "This coupon is not valid for selected products";
                    }
                    // dd($item['user_id'],$userId);
                    if (!empty($couponDetails->users)) {
                        if (!in_array($item['user_id'], $userId)) {
                            $message = "This coupon code is not valid for you.";
                        }
                    }
                    $attPrice = Bag::getProductPrice($item['product_id'], $item['size']);
                    $getCurrency = ProductList::getCurrency($attPrice);
                    if ($cookieValue == false) {
                        $totalPrice = $totalPrice + ($attPrice * $item['quantity']);
                    } else if ($cookieValue == 'NRS') {
                        $totalPrice = $totalPrice + ($attPrice * $item['quantity']);
                    } else if ($cookieValue == 'USD') {
                        $totalPrice = $totalPrice + ($getCurrency['USD_Rate'] * $item['quantity']);
                    } else if ($cookieValue == 'EURO') {
                        $totalPrice = $totalPrice + ($getCurrency['EURO_Rate'] * $item['quantity']);
                    } else if ($cookieValue == 'YEN') {
                        $totalPrice = $totalPrice + ($getCurrency['YEN_Rate'] * $item['quantity']);
                    } else if ($cookieValue == 'INR') {
                        $totalPrice = $totalPrice + ($getCurrency['INR_Rate'] * $item['quantity']);
                    }
                }
                // echo $totalPrice;die;
                if (isset($message)) {
                    $userBagItems = Bag::userBagItems();
                    return response()->json([
                        'status' => false,
                        'message' => $message,
                        'view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])
                    ]);
                } else {
                    //check if amount_type is fixed or percentage
                    if ($couponDetails->amount_type == "Fixed") {
                        $getCurrency = ProductList::getCurrency($couponDetails->amount);

                        if ($cookieValue == false) {
                            $couponAmount = $couponDetails->amount;
                        } else if ($cookieValue == 'NRS') {
                            $couponAmount = $couponDetails->amount;
                        } else  if ($cookieValue == 'USD') {
                            $couponAmount = $getCurrency['USD_Rate'];
                        } else if ($cookieValue == 'EURO') {
                            $couponAmount = $getCurrency['EURO_Rate'];
                        } else if ($cookieValue == 'YEN') {
                            $couponAmount = $getCurrency['YEN_Rate'];
                        } else if ($cookieValue == 'INR') {
                            $couponAmount = $getCurrency['INR_Rate'];
                        }
                    } else {
                        if ($cookieValue == false) {
                            $couponAmount = $totalPrice * ($couponDetails->amount / 100);
                        } else if ($cookieValue == 'NRS') {
                            $couponAmount = $totalPrice * ($couponDetails->amount / 100);
                        } else if ($cookieValue == 'USD') {
                            $couponAmount = $totalPrice * ($getCurrency['USD_Rate'] / 100);
                            //dd($couponAmount);
                        } else if ($cookieValue == 'EURO') {
                            $couponAmount = $totalPrice * ($getCurrency['EURO_Rate'] / 100);
                        } else if ($cookieValue == 'YEN') {
                            $couponAmount = $totalPrice * ($getCurrency['YEN_Rate'] / 100);
                        } else if ($cookieValue == 'INR') {
                            $couponAmount = $totalPrice * ($getCurrency['INR_Rate'] / 100);
                        }
                        //$couponAmount=$totalPrice * ($couponDetails->amount/100);
                    }

                    $grandTotal = $totalPrice - $couponAmount;
                    //add coupon code & amount in session variables
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $request->coupon_code);
                    $message = "Coupon code is applied successfully";

                    $userBagItems = Bag::userBagItems();
                    return response()->json([
                        'status' => true,
                        'message' => $message,
                        'couponAmount' => $couponAmount,
                        'grandTotal' => $grandTotal,
                        'view' => (string)View::make('project.baglist', ['userBagItems' => $userBagItems])
                    ]);
                }
            }
        }
    }
}
