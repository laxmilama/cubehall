@extends('layouts.shop')    

@section('title')
Personal Info - Account Settings
@endsection

@section('content')
<div class="small_container">
    <div class="mt-s fix-cont mb-m" style="margin-bottom: 48px;">        
        <div class="flex-box" data-init="personal">
            <personal-setting class="_STn_lft" :person="{{$person}}"></personal-setting>
        </div>
    </div>
</div>
@endsection