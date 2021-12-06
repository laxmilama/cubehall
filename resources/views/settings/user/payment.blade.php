@extends('layouts.shop')    

@section('title')
Payment - Account Settings
@endsection

@section('content')
<div class="small_container">
    <div class="mt-s fix-cont mb-m" style="margin-bottom: 48px;">        
        <div  data-init="personal">
            <payment-detail-form name="{{Auth::user()->name}}" payments="{{$payments}}"></payment-detail-form>
        </div>
    </div>
</div>
@endsection