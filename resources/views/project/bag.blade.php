@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')

<div class="container">
    <div class="row">
    <?php //$currency=\App\Models\Currency::first();
						$currency= Cookie::get('currency');
						//dd($currency=="NRS");
						?>
        <div class="col-sm-12 col-md-10 col-md-offset-1">  
        @if(empty($userBagItems))

        <p>There is no product in your bag.</p>
        @else
          <div id="AppendBagItem" >
              @include('project.baglist')
          </div>
          <table>
            <tbody>
            <tr>
                    <td>
                    <form id="CouponCode" method="POST" action="javascript:void(0);" enctype="multipart/form-data"
                    @if(Auth::check()) user="1" @endif>
                    {{ csrf_field() }}
				        <div>
				            <label><strong> Coupon Code: </strong> </label>
				            <input type="text" id="coupon_code" name="coupon_code" class="input-medium" placeholder="Enter Coupon/Gift Code">
				            <button type="submit" class="btn"> ADD </button>
				        </div>
				    </form>
                    </td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <a href="{{url('/')}}">
                            Continue Shopping
                        </a></td>
                        <td>
                        <a href="{{url('/checkout')}}">
                            Checkout 
                </a></td>
             </tr>
            </tbody>
          </table>
          @endif
      </div>
   </div>
 </div>
 <script>
            $(document).on('click','.btnItemUpdate',function(){
                if($(this).hasClass('btnMinus')){
                    var quantity=$(this).prev().val();
                    if(quantity<=1){
                        alert("Product quantity must be greater than 1");
                        return false;
                    }
                    else{
                        newquantity=parseInt(quantity)-1;
                    }
                }
                if($(this).hasClass('btnPlus')){
                    var quantity=$(this).prev().prev().val();
                    newquantity=parseInt(quantity)+1;
                }
                var bagid=$(this).data('bagid');
               $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                   type:'post',
                   url:'update-bag-quantity',
                   data:{"bagid":bagid,"quantity":newquantity},
                   success:function(resp){
                      
                       if(resp.status==false){
                         alert(resp.message);
                       }
                       $("#AppendBagItem").html(resp.view);
                   },error:function(){
                       console.log("Error");
                   }
               });
            });

       
        </script>  
       
	<script>
        $("#CouponCode").submit(function(){
            var user=$(this).attr("user");
            if(user==1){
                //do nothing
            }
            else{
                alert("Please log In to use coupon or gift code");
                return false;
            }
            var coupon_code=$("#coupon_code").val();
            
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                   type:'post',
                   url:'/apply-coupon-code',
                   data:{"coupon_code":coupon_code},
                   success:function(resp){
                        if(resp.message !=""){
                            alert(resp.message);
                        }
                     $("#AppendBagItem").html(resp.view);
                     if(resp.couponAmount>=0){
                        if("{{$currency}}"=="NRS")
                        {
                            $(".couponAmount").html("Rs "+resp.couponAmount);
                        }
                        else if("{{$currency}}"=="USD"){
                            $(".couponAmount").html("USD "+resp.couponAmount);
                        }
                        else if("{{$currency}}"=="EURO"){
                            $(".couponAmount").html("EURO "+resp.couponAmount);
                        }
                        else if("{{$currency}}"=="YEN"){
                            $(".couponAmount").html("YEN "+resp.couponAmount);
                        }
                        else{
                            $(".couponAmount").html("INR "+resp.couponAmount);
                        }
                       
                     }
                     else{
                        $(".couponAmount").text(" 0.00");
                     }
                     if(resp.grandTotal>=0){
                        if("{{$currency}}"=="NRS")
                        {
                            $(".grandTotal").html("Rs "+resp.grandTotal);
                        }
                        else if("{{$currency}}"=="USD"){
                            $(".grandTotal").html("USD "+resp.grandTotal);
                        }
                        else if("{{$currency}}"=="EURO"){
                            $(".grandTotal").html("EURO "+resp.grandTotal);
                        }
                        else if("{{$currency}}"=="YEN"){
                            $(".grandTotal").html("YEN "+resp.grandTotal);
                        }
                        else{
                            $(".grandTotal").html("INR "+resp.grandTotal);
                        }
                        
                     }
                 
                   },error:function(){
                       alert("Error");
                   }
               });

        });
    </script>		
@endsection			