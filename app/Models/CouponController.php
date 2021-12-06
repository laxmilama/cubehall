<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\PageCategory;
use App\Models\User;
use Auth;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function coupon(){
        $coupons=Coupon::get()->toArray();
        return view('coupon.coupon',['coupons'=>$coupons]);
    }

    public function updateCoupon(Request $request){
        if($request->ajax()){
            $data=$request->all();
            // dd($data['status']);
            if($data['status']=='Active')
            {
                $status=0;
            }
            else{
                $status=1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function addCoupon(Request $request){

        if($request->isMethod('post')){
            $data=$request->all();
            
            $request->validate([
                'category'=>'required',
                'code'=>'required|string',
                'coupon_option'=>'required',
                'coupon_type'=>'required',
                'expiry_date'=>'required'
            ]);
          // dd($data);
            if(isset($data['users'])){
                $users=implode(',',$data['users']);
            }
            else{
                $users="";
            }
            if(isset($data['category'])){
                $category=implode(',',$data['category']);
            }
            if($data['coupon_option']=='Automatic'){
                $coupon_code=Str::random(8);
            }
            else{
                $coupon_code=$data['coupon_code'];
            }
            $coupon=new Coupon;
            $coupon->coupon_option=$data['coupon_option'];
            $coupon->coupon_code=$coupon_code;
            $coupon->users=$users;
            $coupon->categories=$category;
            $coupon->coupon_type=$data['coupon_type'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->amount=$data['amount'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->status=1;
            $coupon->save();
            return redirect('page/coupons');

        }
        $pages=Auth::user()->pages;
        foreach($pages as $p){ 
            $pageCategories=PageCategory::where('page_id',$p['id'])->get();
           // dd($pageCategories);
        }
        $pageCategories=json_decode(json_encode($pageCategories),true);
        //getting users
        $users=User::select('email')->where('status',1)->get()->toArray();
        //dd($users);
        
        return view('coupon.add_coupon',['pageCategories'=>$pageCategories,'users'=>$users]);
    }
    public function editCoupon(Request $request,Coupon $coupon){
 
        if($request->isMethod('post')){
            $data=$request->all();
           // dd($data);
            $validateData=$request->validate([
                'category'=>'required',
                'coupon_option'=>'required',
                'coupon_type'=>'required',
                'amount_type'=>'required',
                'amount'=>'required',
                'expiry_date'=>'required'
            ], [
                'category.required' => 'Category is required',
                'coupon_option.required' => 'Coupon option is required',
                'coupon_type.required' => 'Coupon type is required',
                'amount_type.required' => 'Amount Type is required',
                'amount.required' => 'Amount is required',
                'expiry_date.required' => 'Expiry date is required'
                
            ]);
            if(isset($data['users'])){
                $users=implode(',',$data['users']);
            }
            else{
                $users="";
            }
            if(isset($data['category'])){
                $category=implode(',',$data['category']);
            }
            $coupon->coupon_option=$data['coupon_option'];
            $coupon->coupon_code=$data['coupon_code'];
            $coupon->users=$users;
            $coupon->categories=$category;
            $coupon->coupon_type=$data['coupon_type'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->amount=$data['amount'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->save();
            return redirect('page/coupons');
            
        }
        $selectCategory=explode(',',$coupon['categories']);
        $selectUser=explode(',',$coupon['users']);

        $pages=Auth::user()->pages;
        foreach($pages as $p){ 
            $pageCategories=PageCategory::where('page_id',$p['id'])->get();
           // dd($pageCategories);
        }
        $pageCategories=json_decode(json_encode($pageCategories),true);
        //getting users
        $users=User::select('email')->where('status',1)->get()->toArray();
        return view('coupon.edit_coupon',['coupon'=>$coupon,'pageCategories'=>$pageCategories,
        'users'=>$users,'selectCategory'=>$selectCategory,
        'selectUser'=>$selectUser]);
    }
}
