@extends('layouts.adminLayout.admin_design')

@section('title')
	Dashboard
@endsection
 @section('content')  

 <div id="AdmCont" class="admin_content_wrapper padlft">
		<div class="sm-container clearPadMobile" data-init="product">
			<product-single :studioid="{{Auth::user()->pages->first()->id}}" symbol="{{Cookie::get('symbol')}}" currency="{{Cookie::get('currency')}}"/>
		</div>
	</div>  
  @endsection   
    

