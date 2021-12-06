@extends('layouts.shop')

@section('title')
    Bag
@endsection
<?php
$currency = Cookie::get('currency');

if (Auth::check()) {
    $id = Auth::user()->id;
} else {
    $id = 0;
}
?>
@section('content')
    <div>
        <div data-init="product-bag" class="_bag_white_bg">
            <bag userid="{{$id}}" symbol="{{Cookie::get('symbol')}}" currency="{{Cookie::get('currency')}}" :products="{{$userBagItems}}"></bag>
        </div>

    </div>
@endsection
