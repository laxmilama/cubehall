@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="AdmCont" class="admin_content_wrapper padlft mt-m">
		<div id="app">
            <order-detail :order="{{$orders}}"></order-detail>
        </div>        
    </div>
@endsection
