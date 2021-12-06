<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\AssociateMeta;
use App\Models\Bag;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductMeta;
use App\Models\ShowOff;
use App\Models\ShowOffEarn;
use App\Notifications\OrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\CurrencyController;

class BagController extends Controller
{

    protected $currencyController;


    public function __construct(CurrencyController $currencyController)
    {
        $this->CurrencyController = $currencyController;
    }

    public function count()
    {
        if (Cookie::has('_uid')) {
            $uid = Cookie::get('_uid');
        } else {
            $now = Carbon::now();
            $rand = mt_rand(1000000, 9999999);
            $u = $now .  $rand;
            $uid = hash('sha256', $u);

            // set cookie
            Cookie::queue('_uid', $uid, 2628000);
        }

        if (Auth::check()) {
            $userBagItems = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product']);
            }, 'store' => function ($query) {
            }])
                ->where('user_id', Auth::user()->id)
                ->orWhere('session_id', $uid)
                ->get()
                ->count();
        } else {
            $userBagItems = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product']);
            }, 'store' => function ($query) {
            }])
                ->where('session_id', $uid)
                ->get()
                ->count();
        }
        return $userBagItems;
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'itemID' => 'required|numeric',
            'sID'  => 'string',
            'storeId' => 'required|numeric',
            'message' => 'string'
        ]);

        if (Cookie::has('_uid')) {
            $uid = Cookie::get('_uid');
        } else {
            $now = Carbon::now();
            $rand = mt_rand(1000000, 9999999);
            $u = $now .  $rand;
            $uid = hash('sha256', $u);

            // set cookie
            Cookie::queue('_uid', $uid, 2628000);
        }

        if (Auth::check()) {
            $product = Bag::where([
                'productmeta_id' => $request->itemID,
                'user_id' => Auth::user()->id
            ])->first();
        } else {
            $product = Bag::where([
                'productmeta_id' => $request->itemID,
                'session_id' => $uid
            ])->first();
        }

        if ($product != null) {
            Bag::findOrFail($product->id)
                ->update(['quantity', $product->quantity++]);
            return response('Cart has been updated!', 200);
        }

        $bag = new Bag;

        if (Auth::check()) {
            $bag->user_id = Auth::user()->id;
        } else {
            $bag->session_id = $uid;
        }
        // return $request->sID;
        if ($request->sID != 'null') {
            $bag->showoff_id = $request->sID;
        }

        if ($request->message != 'null') {
            $bag->customize_message = $request->message;
        }

        $bag->productmeta_id = $request->itemID;
        $bag->page_id = $request->storeId;
        $bag->quantity = 1;
        //dd($bag);
        $bag->save();
        return $request;
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        // return Auth::user()->id;

        if (Auth::check()) {
            $product = Bag::where('id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->first();
        } else {
            $product = Bag::where([
                'id' => $request->id,
                'session_id' => session()->get('session_id')
            ])->first();
        }

        if ($product) {
            Bag::where('id', $product->id)->update(['quantity' => $request->quantity]);
            return response('updated', 200);
        } else {
            return response('failed', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bag $item)
    {
        if (Auth::check()) {
            if ($item->user_id == Auth::user()->id) {
                $item->delete();
                return response('success', 200);
            } else if ($item->session_id == Cookie::get('_uid')) {
                $item->delete();
                return response('success', 200);
            } else {
                return response('failed', 403);
            }
        } else {
            if (Cookie::has('_uid')) {
                if ($item->session_id == Cookie::get('_uid')) {
                    $item->delete();
                    return response('success', 200);
                }
            }

            return response('failed', 403);
        }
        return response('failed', 403);
    }


    public function verify(Request $request)
    {
        // associate
        $minutes = 43200; //for 30 days in minute

        $address = DeliveryAddress::find($request->address);

        // return $address;

        // return $address;

        $user_id = Auth::user()->id;

        if (Cookie::has('_uid')) {
            $uid = Cookie::get('_uid');
        } else {
            $now = Carbon::now();
            $rand = mt_rand(1000000, 9999999);
            $u = $now .  $rand;
            $uid = hash('sha256', $u);
            Cookie::queue('_uid', $uid, 2628000);
        }

        if (Auth::check()) {
            $items = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->with(['shipping' => function ($db) {
                    }]);
                }]);
            }, 'store' => function ($query) {
            }, 'coupon'])
                // }, 'coupon','bagmetaproduct.productmeta.shipping'])
                ->where('user_id', Auth::user()->id)
                ->orWhere('session_id', $uid)
                ->orderBy('id', 'Desc')
                ->get();
        } else {
            $items = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product']);
            }, 'store' => function ($query) {
            }, 'coupon'])
                ->where('session_id', $uid)
                ->orderBy('id', 'Desc')
                ->get();
        }
        // return $items;
        // calculate total with discount
        $total = 0;
        $discount = 0;
        $shipping = 0;
        foreach ($items as $item) {

            $total = $total + ($this->localPrice($item->bagmetaproduct->price, $item->bagmetaproduct->currency) * $item->quantity);

            if ($item->coupon) {
                if ($item->coupon->max_redemptions != 0) {
                    if ($item->coupon->times_redeemed <= $item->coupon->max_redemptions) {
                        $canRedeem = true;
                    } else {
                        $canRedeem = false;
                    }
                } else {
                    $canRedeem = true;
                }


                if ($canRedeem) {
                    if ($item->coupon->type == "Fixed") {
                        $discount = $discount + $this->localPrice($item->coupon->amount_off, $item->coupon->currency);
                    } else if ($item->coupon->type == "Percentage") {
                        $discount = $discount +  ($this->localPrice($item->bagmetaproduct->price / 100, $item->bagmetaproduct->currency)) * $item->coupon->percent_off;
                    }
                } else {
                    return response('Invalid coupon, please try again!', 406);
                }
            }

            // calculate shipping charge
            if ($item->bagmetaproduct->product->shipping) {
                $shipping = $shipping + $this->Shipping($item->bagmetaproduct->product->shipping, $address, $item->quantity);
            }
        }
        // return $shipping;
        // return $total;
        $newTotal = $total - $discount + $shipping;

        return response()->json(["total" => round($newTotal, 2)]);
    }

    public function shipping($ship, $address, $quantity)
    {
        $shipping = 0;
        if ($ship) {
            $add= 0;
            // check if shipping address is matched with delivery address city of the same country
            foreach ($ship as $adr) {
                if ($address->country == $adr->country && strtolower($address->city) == strtolower($adr->city)) {
                    $sc = $this->localPrice($adr->primary, $adr->currency);
                    if($quantity > 1){
                        $add = ($quantity -1) * $this->localPrice($adr->additional, $adr->currency);
                    }
                    
                    $shipping =  $sc + $add;
                    return $shipping;
                }
            }

            if ($shipping == 0) {
                // else check if everywhere is available
                foreach ($ship as $adr) {
                    if ($address->country == $adr->country && $adr->city == "everywhere") {
                        $sc = $this->localPrice($adr->primary, $adr->currency);
                        if($quantity > 1){
                            $add = ($quantity -1) * $this->localPrice($adr->additional, $adr->currency);
                        }
                        $shipping =  $sc + $add;
                        return $shipping;
                    }
                }
            }

            // else if it is available for rest of the world
            if ($shipping == 0) {
                foreach ($ship as $adr) {
                    if ($adr->country == "EVR") {
                        $sc = $this->localPrice($adr->primary, $adr->currency);
                        if($quantity > 1){
                            $add = ($quantity -1) * $this->localPrice($adr->additional, $adr->currency);
                        }
                        $shipping = $sc + $add;
                        return $shipping;
                    }
                }
            }
        }
        return 0;
    }


    public function checkout(Request $request)
    {
        // associate
        $minutes = 43200; //for 30 days in minute

        $value = Cookie::get('associate');

        $d = json_decode($value, true);
        // Remove cookies that are expired
        if ($d != null) {
            foreach ($d as $k => $v) {
                if (date("Y-m-d") > $v['expires']) {
                    unset($d[$k]);
                }
            }
        } else {
            $d = [];
        }

        $address = DeliveryAddress::find($request->address);

        // return $address;

        $user_id = Auth::user()->id;
        if (Cookie::has('_uid')) {
            $uid = Cookie::get('_uid');
        } else {
            $now = Carbon::now();
            $rand = mt_rand(1000000, 9999999);
            $u = $now .  $rand;
            $uid = hash('sha256', $u);
            Cookie::queue('_uid', $uid, 2628000);
        }

        if (Auth::check()) {
            $items = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->with(['shipping' => function ($db) {
                    }]);
                }]);
            }, 'store' => function ($query) {
            }, 'coupon'])
                // }, 'coupon','bagmetaproduct.productmeta.shipping'])
                ->where('user_id', Auth::user()->id)
                ->orWhere('session_id', $uid)
                ->orderBy('id', 'Desc')
                ->get();
        } else {
            $items = Bag::with(['bagmetaproduct' => function ($query) {
                $query->with(['product']);
            }, 'store' => function ($query) {
            }, 'coupon'])
                ->where('session_id', $uid)
                ->orderBy('id', 'Desc')
                ->get();
        }
        // return $items;

        // calculate total with discount
        $total = 0;
        $discount = 0;
        $shipping = 0;
        foreach ($items as $item) {
            $sc = 0;
            $add = 0;
            $total = $total + ($this->localPrice($item->bagmetaproduct->price, $item->bagmetaproduct->currency) * $item->quantity);

            if ($item->coupon) {
                if ($item->coupon->max_redemptions != 0) {
                    if ($item->coupon->times_redeemed <= $item->coupon->max_redemptions) {
                        $canRedeem = true;
                    } else {
                        $canRedeem = false;
                    }
                } else {
                    $canRedeem = true;
                }

                if ($canRedeem) {
                    if ($item->coupon->type == "Fixed") {
                        $discount = $discount + $this->localPrice($item->coupon->amount_off, $item->coupon->currency);
                    } else if ($item->coupon->type == "Percentage") {
                        $discount = $discount +  ($this->localPrice($item->bagmetaproduct->price / 100, $item->bagmetaproduct->currency)) * $item->coupon->percent_off;
                    }
                } else {
                    return response('Invalid coupon, please try again!', 406);
                }
            }

            if ($item->bagmetaproduct->product->shipping) {
                $shipping = $shipping + $this->Shipping($item->bagmetaproduct->product->shipping, $address, $item->quantity);
            }
            // $shipping = $shipping + $sc;
        }

        // return $shipping;
        $newTotal = $total - $discount + $shipping;

        // return $total;

        if ($request->method == "Khalti") {

            $args = http_build_query(array(
                'token' => $request->token,
                'amount'  => $newTotal * 100
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
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $res = json_decode($response, true); //decode the response

            // return $res;

            // return $res;
            if (isset($res['idx']))  //check whether there is idx and also the amount in response with your database(I havenot done that)
            {

                // create new order
                $order = new Order;
                $order->user_id = $user_id;
                $order->delivery = json_encode($address);
                $order->total_amount = $request->totalAmount;
                $order->identifier = $this->getUniqueID();
                $order->currency = $request->currency;
                $order->save();


                // now get items from bag;                
                foreach ($items as $item) {

                    // increase redemptions on coupon
                    if ($item->coupon_id) {
                        // $coupon = Coupon::find($item->coupon_id);
                        //  Coupon::find($item->coupon_id);
                        Coupon::where('id', $item->coupon_id)->increment('times_redeemed', 1);
                        // $coupon->update('times_redeemed', $coupon->times_redeemed + 1);
                    }

                    $product = ProductMeta::find($item->productmeta_id);

                    $OP = new OrderProduct;
                    $OP->order_id = $order->id;
                    $OP->user_id = $user_id;
                    $OP->products_meta_id = $item->productmeta_id;
                    $OP->page_id = $item->page_id;
                    $OP->quantity = $item->quantity;
                    $OP->customize_message = $item->customize_message;

                    $OP->price = $product->price;
                    $OP->currency = $product->currency;
                    $OP->thumbnail = $product->thumbnail;
                    $OP->product_name = $product->product->name;
                    $OP->slug = $product->product->slug;

                    // give priority to showoff
                    // and then associate link

                    if ($item->showoff_id != null) {
                        // return $item->showoff_id;
                        $showoff = ShowOff::where('slug', $item->showoff_id)->first();

                        // add money to user
                        if ($showoff) {
                            $earn = new ShowOffEarn();
                            $amount = ($product->price / 100) * 15;
                            $earn->amount = ($amount / 100) * 67;
                            $earn->currency = $product->currency;
                            $earn->showoff_id = $showoff->id;
                            $earn->user_id = $showoff->user_id;
                            $earn->save();
                        }
                    } else {
                        // return $d;
                        foreach ($d as $k => $v) {
                            $a = Associate::where('url', $v['url'])->first();
                            // return $a;
                            if ($a) {
                                if ($product->product->id == $a->product_id) {
                                    // Give 15% to associate link
                                    $asMeta = new AssociateMeta();
                                    $amount = ($product->price / 100) * 15;
                                    $asMeta->amount = ($amount / 100) * 67;
                                    $asMeta->currency = $product->currency;
                                    $asMeta->associate_id = $a->id;
                                    $asMeta->user_id =  $a->user_id;
                                    $asMeta->save();
                                }
                            }
                        }
                    }

                    $OP->save();
                    $studio =   $OP->studioes->user;
                    foreach ($studio as $s) {
                        $s->notify(new OrderNotification($OP, $OP->customers));
                    }
                }

                // clear Bag after completing the order;
                Bag::where(['user_id' => $user_id])
                    ->OrWhere('session_id', Cookie::get('_uid'))
                    ->delete();
                return response('success', 200);
            }
            return response('Oops! data missmatched', 200);
        }
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


    function getUniqueID()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base  = strlen($characters) - 1;
        $output = "";
        $len = 2;
        for ($i = 0; $i < $len; $i++) {
            $output = $output . $characters[mt_rand(0, $base)];
        }
        $a = Carbon::now()->timestamp;
        $b = $output . substr($a, 0, 4) . "-" . mt_rand(100, 9999) . "-" . substr($a, 4, strlen($a)) . mt_rand(1, 100);
        return $b;
    }

    public function applyCoupon(Request $request)
    {
        // validate request
        $request->validate([
            'code' => 'required|alpha_num',
        ]);

        // if validation successfull
        // get all coupons with requested code   
        $coupon = Coupon::where('code', $request->code)
            ->where('status', 1)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        // return $coupon;

        if (!$coupon) {
            return response('Invalid coupon, please try again!', 406);
        } else {

            $bagItems = Bag::whereNull('coupon_id')
                ->with(['bagmetaproduct' => function ($query) {
                    $query->with(['product']);
                }, 'store' => function ($query) {
                }])
                ->where('user_id', Auth::user()->id)
                ->get();

            if (count($bagItems) <= 0) {
                return response('Your bag is empty', 406);
            } else {
                if ($coupon->max_redemptions != 0) {
                    if ($coupon->times_redeemed <= $coupon->max_redemptions) {
                        $canRedeem = true;
                    } else {
                        $canRedeem = false;
                    }
                } else {
                    $canRedeem = true;
                }

                if ($canRedeem) {
                    if ($coupon->option == "Collections") {
                        // collection_id 
                        $collections = json_decode($coupon->option_meta);
                        // return $coupon;

                        foreach ($bagItems as $key => $item) {
                            foreach ($collections as $ky => $coll) {
                                // return $item;
                                if ($coll->id == $item->bagmetaproduct->product->collection_id) {
                                    if ($item->page_id == $coupon->page_id) {
                                        // $item->update(['coupon_id' => $coupon->id]);
                                        $c = Bag::where('id', $item->id)->update(['coupon_id' => $coupon->id]);
                                        return response()->json(['coupon' => $coupon, 'item' => $item->id]);
                                    }
                                }
                            }
                        }
                        return response('Invalid coupon, please try again!', 406);
                    } else if ($coupon->option == "Products") {
                        $products = json_decode($coupon->option_meta);
                        foreach ($bagItems as $key => $item) {
                            foreach ($products as $ky => $pro) {
                                if ($pro == $item->bagmetaproduct->product->id) {
                                    if ($item->page_id == $coupon->page_id) {
                                        // $item->update(['coupon_id' => $coupon->id]);
                                        $c = Bag::where('id', $item->id)->update(['coupon_id' => $coupon->id]);
                                        return response()->json(['coupon' => $coupon, 'item' => $item->id]);
                                    }
                                }
                            }
                        }
                        return response('Invalid coupon, please try again!', 406);
                    } else {
                        foreach ($bagItems as $key => $item) {
                            if ($item->page_id == $coupon->page_id) {
                                // $item->update(['coupon_id' => $coupon->id]);
                                $c = Bag::where('id', $item->id)->update(['coupon_id' => $coupon->id]);
                                return response()->json(['coupon' => $coupon, 'item' => $item->id]);
                            }
                        }
                        return response('Invalid coupon, please try again!', 406);
                    }
                } else {
                    return response('Invalid coupon, please try again!', 406);
                }
            }
        }
    }
}
