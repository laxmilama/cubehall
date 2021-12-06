@extends('layouts.shop')    

@section('title')
Security - Account Settings
@endsection

@section('content')
<div class="small_container">
    <div class="mt-s fix-cont mb-m" style="margin-bottom: 48px;">        
        <div class="flex-box" data-init="personal">
            <change-password class="_STn_lft" :person="{{$person}}"></change-password>
        </div>
    </div>
</div>
@endsection