@extends('layouts.adminLayout.admin_design')
@section('content')

    <div id="AdmCont" class="sm-container">
        <div id="app">
            <coupon :collections="{{$pageCategories}}" :products="{{$products}}" :shoppers="{{$shoppers}}"></coupon>
        </div>
    </div>
@endsection
