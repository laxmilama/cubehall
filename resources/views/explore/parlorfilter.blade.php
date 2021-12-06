@extends('layouts.shop')

@section('title')
    Explore
@endsection

@section('content')
    <div class="container clearPadMobile" id="app">
        <parlor-explore-filter currency="{{Cookie::get('currency')}}"  symbol="{{Cookie::get('symbol')}}"></parlor-explore-filter>
    </div>
@endsection
