@extends('layouts.adminLayout.admin_design')

@section('title')
	Varient
@endsection
 @section('content')  

 <div id="AdmCont" class="admin_content_wrapper padlft">
		<div data-init="varient">
			<product-varient :studioid="{{Auth::user()->pages->first()->id}}" symbol="{{Cookie::get('symbol')}}" currency="{{Cookie::get('currency')}}" />
		</div>
	</div>  
  @endsection   
    

