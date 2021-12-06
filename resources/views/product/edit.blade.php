@extends('layouts.adminLayout.admin_design')

@section('title')
Edit Product
@endsection
 @section('content')  

 <div id="AdmCont" class="admin_content_wrapper padlft">
		<div class="sm-container" data-init="product">
            
			<edit-product :product="{{$product}}" :studioid="{{Auth::user()->pages->first()->id}}"></edit-product>
		</div>
	</div>  
  @endsection   
    

