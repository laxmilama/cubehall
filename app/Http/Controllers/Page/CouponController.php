<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponProductResource;
use App\Http\Resources\CouponShopperResource;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\OrderProduct;
use App\Models\PageCategory;
use App\Models\ProductList;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CouponController extends Controller
{

    public function index(){
        $page = Auth::user()->pages[0];
        return Coupon::where('page_id', $page->id)->latest()->paginate(10);
    }


    public function coupon()
    {
        $pages = Auth::user()->pages;
        foreach ($pages as $p) {
            $pageCategories = PageCategory::where('page_id', $p['id'])
                ->select('name', 'id')->get();
        }
        //getting users
        $users = User::select('email')->where('status', 1)->get()->toArray();
        //dd($users);
        foreach ($pages as $p) {
            $products = CouponProductResource::collection(Cache::remember('products_coupon', 1, function () {
                return ProductList::where('page_id', Auth::user()->pages[0]->id)->where('status', 1)->get();
            }));
        }

        foreach ($pages as $p) {
            $shoppers = CouponShopperResource::collection(Cache::remember('shoppers_coupon', 1, function () {
                 $uid = OrderProduct::where('page_id', Auth::user()->pages[0]->id)->pluck('user_id');
                 return User::whereIn('id', $uid)->get();
            }));
        }

        return view('coupon.coupon', [
            'pageCategories' => $pageCategories, 
            'products' => json_encode($products),
            'shoppers' => json_encode($shoppers),
        ]);
    }

    public function updateCoupon(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data['status']);
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Coupon::where('id', $data['coupon_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'coupon_id' => $data['coupon_id']]);
        }
    }

    public function addCoupon(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'code'=>'required|string',
                'option'=>'required',
                'type'=>'required',
                'expiry_date'=>'required',
                'elegible'=>'required'
            ]);

            $coupon = new Coupon;
            $coupon->code = $request->code;
            $coupon->option = $request->option;
            $coupon->type = $request->type;
            $coupon->eligibility = $request->elegible;
            $coupon->page_id = Auth::user()->pagess[0]->id;

            if($request->option == "All Products")
            {
                $coupon->option_meta = null;
            }else if($request->option == "Collections")
            {
                $coupon->option_meta = $request->collections;
            }else if($request->option == "Products")
            {
                $coupon->option_meta = $request->products;
            }

            $coupon->times_redeemed = 0;

            // types
            if($request->type == "Percentage"){
                $coupon->percent_off = $request->percentage;
                $coupon->amount_off = null;
            }else if($request->type == "Fixed"){
                $coupon->amount_off = $request->fixed;
                $coupon->percent_off = null;
            }

            if($request->max_redemption != "null"){
                $coupon->max_redemptions = $request->max_redemtion;
            }

            if($request->elegible == "Everyone"){
                $coupon->elegible_meta = null;
            }else if($request->elegible == "Secret")
            {
                $coupon->elegible_meta = null;

            }else if($request->elegible == "Customer"){
                $coupon->elegible_meta = $request->shoppers;
            }

            if($request->percentage != 'null' && $request->percentage > 100){
                return response('Percentage should be less than 100. ' . $request->percentage , 400);
            }
            $coupon->expires_at = $request->expiry_date;
            $coupon->status = 1;
            $coupon->save();

            return $coupon;

        }
    }
    public function editCoupon(Request $request, Coupon $coupon)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $validateData = $request->validate([
                'category' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required',
                'expiry_date' => 'required'
            ], [
                'category.required' => 'Category is required',
                'coupon_option.required' => 'Coupon option is required',
                'coupon_type.required' => 'Coupon type is required',
                'amount_type.required' => 'Amount Type is required',
                'amount.required' => 'Amount is required',
                'expiry_date.required' => 'Expiry date is required'

            ]);
            if (isset($data['users'])) {
                $users = implode(',', $data['users']);
            } else {
                $users = "";
            }
            if (isset($data['category'])) {
                $category = implode(',', $data['category']);
            }
            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->users = $users;
            $coupon->categories = $category;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->save();
            return redirect('page/coupons');
        }
        $selectCategory = explode(',', $coupon['categories']);
        $selectUser = explode(',', $coupon['users']);

        $pages = Auth::user()->pages;
        foreach ($pages as $p) {
            $pageCategories = PageCategory::where('page_id', $p['id'])->get();
            // dd($pageCategories);
        }
        $pageCategories = json_decode(json_encode($pageCategories), true);
        //getting users
        $users = User::select('email')->where('status', 1)->get()->toArray();
        return view('coupon.edit_coupon', [
            'coupon' => $coupon, 'pageCategories' => $pageCategories,
            'users' => $users, 'selectCategory' => $selectCategory,
            'selectUser' => $selectUser
        ]);
    }
}
