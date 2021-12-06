@extends('layouts.shop')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    <div class="container clearPadMobile">
        <div class="row">
            <div data-init="searchFilter">
                <browse-category currency="{{Cookie::get('currency')}}"  symbol="{{Cookie::get('symbol')}}"></browse-category>
            </div>
        </div>
    </div>

@endsection
