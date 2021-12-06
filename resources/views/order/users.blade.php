@extends('layouts.shop')

@section('title')
    Orders
@endsection

@section('content')
<div>
    <div class="sm-container">
        <div style="display: inline-block; width:100%;">
            <div>
                <h1>Orders</h1>
            </div>

            <div id="app">
                <tabs-dyna>
                    <tab name="Upcoming">
                           <order-upcoming symbol="{{Cookie::get('symbol')}}" currency="{{Cookie::get('currency')}}"></order-upcoming>
                    </tab>
                    <tab name="Completed">
                        <order-completed symbol="{{Cookie::get('symbol')}}" currency="{{Cookie::get('currency')}}"></order-completed>
                    </tab>
                </tabs-dyna>

            </div>
        </div>

    </div>
</div>
@endsection