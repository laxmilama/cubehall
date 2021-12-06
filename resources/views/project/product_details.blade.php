@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')
<?php use App\Models\ProductList;?>
<?php use App\Models\ProductMeta;?>
<?php use App\Models\Currency;?>
<div class="container">
	<div class="row">
		<div id="gallery" class="span3">
			<img src="{{asset('img/micro-vanity-s0918onmj_m900_1440_1200.webp')}}" alt="" style="width:20%;">                            
		</div>
		
		<div class="span12">
			<h3>{{$product_detail['name']}}</h3>
			
				<form class="form-horizontal qtyFrm" action="{{url('add-to-bag')}}" method="POST" >@csrf
					<div class="control-group">
				
						<?php
					
					foreach($product_detail->metas as $meta){ 
							$getCurrency=ProductMeta::getCurrency($meta->price);
						 
						 
					//	dd($getCurrency);
					}
						?>
					
						
						<?php //$currency=\App\Models\Currency::first();
						$currency= Cookie::get('currency');
						//dd($currency=="NRS");
						?>
						<div class="getCurrencyPrice">
				
					
							 @if($currency == false )
							 Rs.	{{$product_detail['metas'][0]['price']}}
							 @elseif($currency== 'NRS')
							 Rs.	{{$product_detail['metas'][0]['price']}}
							 @elseif($currency== 'USD')
									USD {{$getCurrency['USD_Rate']}}<br>
								@elseif($currency == 'EURO')
									ERO {{$getCurrency['EURO_Rate']}}<br>
								@elseif($currency == 'YEN')
									YEN {{$getCurrency['YEN_Rate']}}<br>
								@elseif($currency== 'INR')
									INR {{$getCurrency['INR_Rate']}}
								@endif
						
							</div>
					
							<div class="getPrice">
							@if($product_detail['metas'][0]['size'] != null)
							
							<select class="span2 pull-left"  name="size" id="getSizePrice" page-id="{{$product_detail['page_id']}}" product-id="{{$product_detail['id']}}">
								<option value="" selected>Select Size</option>
								@foreach($product_detail['metas'] as $meta)
								<option>{{$meta['size']}}</option>
								@endforeach
								
							</select>
							@error('size')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
						@else
							<input type="hidden" name="size" id="getSizePrice" value=""/>
						@endif
					
			
						@if($product_detail['metas'][0]['material'] != null)
							<select class="span2 pull-left" name="material" id="getMaterial" page-id="{{$product_detail['page_id']}}" product-id="{{$product_detail['id']}}">
								<option value="" selected>Select Material</option>
								@foreach($product_detail['metas'] as $meta)
								<option>{{$meta['material']}}</option>
								@endforeach	
							</select>
							@error('material')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
						@else
							<input type="hidden" name="material" id="getMaterial" value=""/>
							@endif
				
						@if($product_detail['metas'][0]['colorhex'] != null)
							<select class="span2 pull-left" name="colorhex" id="getColorPrice" page-id="{{$product_detail['page_id']}}" product-id="{{$product_detail['id']}}">
								<option value="" selected>Select Color</option>
								@foreach($product_detail['metas'] as $meta)
								<option>{{$meta['colorhex']}}</option>
								@endforeach	
							</select>
						
							@error('colorhex')
							
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
						@else
							<input type="hidden" name="colorhex" id="getColorPrice" value=""/>
						@endif
					</div>
					</div>
						<input type="hidden" name="quantity" id="quantity" value="1"/>
							<input type="hidden" name="page_id" id="page_id" value="{{$product_detail['page_id']}}"/>
					
						</div>
						@foreach($product_detail->metas as $meta)
					
							<input type="hidden" name="product_id" id="product_id" value="{{$meta->id}}">
						@endforeach
						
							<button type="submit" class="btn btn-large btn-primary pull-right"> Add to Bag <i class=" icon-shopping-cart"></i></button>
			
				</form>
			</div>
		</div>
</div>
<script>
 $(".getPrice").change(function(){
	// $(document).on('change','.getPrice',function(){
		var material=$('#getMaterial').val();
		var size=$('#getSizePrice').val();
		var colorhex=$('#getColorPrice').val();
		var quantity=$('#quantity').val();
		var page_id=$('#page_id').val();
		var product_id=$("#product_id").val();
	
    $.ajax({
		headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		url:'/get-product-price',
		data:{size:size,material:material,colorhex:colorhex,quantity:quantity,product_id:product_id,page_id:page_id},
		type:'post',
		success:function(resp){
			var arr=resp.split('#');
			var arr1=arr[0].split(',');
			var rs=arr1[0];
			if("{{$currency}}"==false)
			{
				$(".getCurrencyPrice").html("Rs "+arr1[0]);
			}
			else if("{{$currency}}"=="NRS")
			{
				$(".getCurrencyPrice").html("Rs "+arr1[0]);
			}
			else if("{{$currency}}"=="USD"){
				$(".getCurrencyPrice").html("USD "+arr1[1]);
			}
			else if("{{$currency}}"=="EURO"){
				$(".getCurrencyPrice").html("EURO "+arr1[2]);
			}
			else if("{{$currency}}"=="YEN"){
				$(".getCurrencyPrice").html("YEN "+arr1[3]);
			}
			else{
				$(".getCurrencyPrice").html("INR "+arr1[4]);
			}
		
		},error:function(){
		//	alert('Error');
		}
    });
});
	</script>
@endsection