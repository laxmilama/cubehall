@extends('layouts.shop')    

@section('title')
Following
@endsection

@section('content')
<div class="following-list">
    <div data-init="story" class="scrollable ">
        <sliders :viewer="{{ Auth::user() }}" ></sliders>
    </div>
</div>
<div id="app" class="_MBL_fix_btm">
    <following-feed currency="{{Cookie::get('currency')}}"  symbol="{{Cookie::get('symbol')}}"></following-feed>
</div>
@endsection