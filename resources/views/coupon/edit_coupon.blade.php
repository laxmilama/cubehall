@extends('layouts.adminLayout.admin_design')
 @section('content')
 
 <div class="admin_content_wrapper">
    <h2>Add Coupon</h2>
        <form action="{{url('page/edit-coupon/'.$coupon['id'])}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
        <div>
            <input type="hidden" name="coupon_option" value="{{$coupon['coupon_option']}}">
            <input type="hidden" name="coupon_code" value="{{$coupon['coupon_code']}}">   
            <label for="coupon_option"><strong>Coupon Option</strong></label>
            <span>{{$coupon['coupon_option']}}</span><br>
            <label for="coupon_code"><strong>Coupon Code:</strong></label>
            <span>{{$coupon['coupon_code']}}</span>
         </div>
        <div>
            <label for="coupon_type"><strong>Coupon Type</strong></label><br>
            <span><input type="radio" name="coupon_type" value="Multiple Times" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=='Multiple Times') checked @endif>&nbsp;&nbsp;&nbsp;Multiple Times &nbsp;&nbsp;&nbsp;</span>
            <span><input type="radio" name="coupon_type" value="Single Times" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=='Single Times') checked @endif>&nbsp;&nbsp;&nbsp;Single Times &nbsp;&nbsp;&nbsp;</span><br>
            @error('coupon_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         </div>
         <div>
            <label for="amount_type"><strong>Amount Type</strong></label><br>
            <span><input type="radio"  name="amount_type" value="Percentage" @if(isset($coupon['amount_type']) && $coupon['amount_type']=='Percentage') checked @endif>&nbsp;&nbsp;&nbsp;Percentage &nbsp;(in %)&nbsp;&nbsp;</span>
            <span><input type="radio" name="amount_type"  value="Fixed" @if(isset($coupon['amount_type']) && $coupon['amount_type']=='Fixed') checked @endif>&nbsp;&nbsp;&nbsp;Fixed &nbsp;&nbsp;&nbsp;(in NRS)</span><br>
            @error('amount_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         </div>
         <div>   
            <label for="amount"><strong>Amount</strong></label><br>
            <input type="number" id="amount" name="amount" value="{{$coupon['amount']}}"><br>
            @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>   
            <label for="category"><strong>Category</strong></label><br>
           
            <select class="span2 pull-left select2" name="category[]" id="category" multiple >
                <option value="">Select Studio Category</option>
                @foreach($pageCategories as $meta)
             
                <option value="{{$meta['id']}}" @if(in_array($meta['id'],$selectCategory)) selected @endif>{{$meta['category_name']}}</option>
                @endforeach	
			</select>
            @error('category[]')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>   
            <label for="user"><strong>User</strong></label><br>
            <select class="span2 pull-left select2" name="users[]" id="users" multiple>
                <option value="">Select Users</option>
                @foreach($users as $meta)
                <option value="{{$meta['email']}}" @if(in_array($meta['email'],$selectUser)) selected @endif>{{$meta['email']}}</option>
                @endforeach	
			</select>
        </div>
        
        <div>   
            <label for="expiry_date"><strong>Expiry Date</strong></label><br>
            <input type="date" id="expiry_date" name="expiry_date" value="{{$coupon['expiry_date']}}"><br><br>
            @error('expiry_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
            <input type="submit" value="Update">
        </form> 
  </div>
  <script>
    $("#manualCoupon").click(function(){
        $("#couponField").show();
    });
    $("#automaticCoupon").click(function(){
        $("#couponField").hide();
    });
  </script>
 @endsection       