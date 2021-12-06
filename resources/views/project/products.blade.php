@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')

<div class="container">

	<div class="row">
	

<aside class="sidebar">
	<form  method="get" action="{{url('/filter')}}" >
	<?php
		if(isset($product_category)){
			echo "<input type='hidden' name='product_category' value='$product_category'>";
		}
		?>
		<select id="order_by" name="order_by" onchange="this.form.submit();" class="form-control" style="width: 200px; float: right">

			<option value="">Default</option>
			<option value="Price_ASC" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Price_ASC') selected @endif>Price: low to high</option>
			<option value="Price_DESC"  @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Price_DESC') selected @endif>Price: high to low</option>
			<option value="Newest"  @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Newest') selected @endif>Sort by Latest</option>
			<option value="Rating"  @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Rating') selected @endif>Sort by Rating</option>
		</select>
		
	
		<h1 class="sidebar-heading">
			Filter by
		</h1>

		<input type="submit" value="Apply" class="btn btn-primary">

		<ul class="filter ul-reset">
			
		<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Price range
					</h1>

					<div class="filter-attribute-list-inner">
						<input type="text" name="product_max_price" 
						placeholder="MAX"
						 value="<?php if(isset($selected_max_price)){ echo $selected_max_price; } ?>">
						<input type="text" name="product_min_price"
						 placeholder="MIN" 
						 value="<?php if(isset($selected_min_price)){ echo $selected_min_price; } ?>">
						 <input type="submit" value="Apply" class="btn btn-primary">
					</div>				

				</section>
			</li>

			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Material
					</h1>
					<ul class="filter-attribute-list ul-reset">
					<div class="filter-attribute-list-inner">
							<?php
							if(isset($product_size)){
								//dd($product_size);
								
								foreach($product_size as $key){
									//foreach($ke['metas'] as $key){
										$filter_cat=explode('%',$key['name']);
									//dd($filter_cat);
									//echo $key->size;
							?>
								<li class="filter-attribute-item">
									<input type="checkbox" name="product_size[]" class="form-check-input" 
									value="<?php echo explode('%',$key['name']) ?>"   @if(isset($selected_size)) 
										@if (in_array($key['name'], $selected_size)) 	checked="checked" 
											@endif @endif onChange="this.form.submit()">
									<label for="colour-attribute-1" class="filter-attribute-label ib-m">
										<?php echo $key['name']; ?>
									</label>
								</li>
								
							<?php
								}	
							}
							//}
							?>
						</div>
					</ul>
				</section>
			</li>


			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Color
					</h1>
					<ul class="filter-attribute-list ul-reset">
					<div class="filter-attribute-list-inner">
							<?php
							if(isset($product_color)){ 
								//dd($product_color);
								foreach($product_color as $key){
									if($key !== null){ 
									//foreach($ke['metas'] as $key){
									//dd($key);
							?>
								<li class="filter-attribute-item">
									<input type="checkbox" name="product_color[]" class="form-check-input"
									 value="<?php echo $key->colorhex; ?>" onChange="this.form.submit()"
									  @if(isset($selected_color)) 
									 	@if (in_array($key->colorhex, $selected_color)) checked="checked" 
										 	@endif @endif >
									<label for="colour-attribute-1" class="filter-attribute-label ib-m">
										<?php echo $key->colorhex; ?>
									</label>
								</li>
							<?php
								}	
							}
						}
							?>
						</div>
					</ul>
				</section>
			</li>


			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Material
					</h1>
					<ul class="filter-attribute-list ul-reset">
					<div class="filter-attribute-list-inner">
							<?php
							if(isset($product_material)){
								
								foreach($product_material as $key){
									//foreach($ke['metas'] as $key){
							?>
								<li class="filter-attribute-item">
									<input type="checkbox" name="product_material[]" class="form-check-input" 
									value="<?php echo $key->material; ?>"  onChange="this.form.submit()"
									@if(isset($selected_material)) 	@if (in_array($key->material, $selected_material)) 	checked="checked" 	@endif @endif >
									<label for="colour-attribute-1" class="filter-attribute-label ib-m">
										<?php echo $key->material; ?> 
									</label>
								</li>
							<?php
								}	
							}
						//}
							?>
						</div>
					</ul>
				</section>
			</li>

		</ul>
	</form>
</aside>



<?php

if(isset($data)){
	// echo "<pre/>";
	 //dd($data);

	if($data !== ""){

?><div class="container">
<div class="row">
@foreach($data as $pro)

				<div class="span12">
					<h3>{{$pro->name}}  </h3>
					<small>- Brand Name</small>
					<hr class="soft"/>
					<small>100 items in stock</small>
					<form class="form-horizontal qtyFrm" action="{{url('add-to-bag')}}" method="POST" >@csrf
						<div class="control-group">
							<h4 class="getPrice">
								{{$pro->price}}
							</h4>
					
							
								
						</div>
					
					
						<button type="submit" class="btn btn-large btn-primary pull-right"> Add to Bag <i class=" icon-shopping-cart"></i></button>
					</form>
				@endforeach
				</div>
		</div>
				

{{ $data->appends(request()->input())->links() }}

<?php
	}else{
		echo "<center><h3>No products found.</h3></center>";
	}
	?>

<?php		
}
?>



@endsection