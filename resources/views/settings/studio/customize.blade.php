@extends('layouts.adminLayout.admin_design')

@section('title')
	Studio Settings
@endsection
@section('content')
<section data-init="studio" class="admin_content_wrapper">
    {{-- {{dd($studio)}} --}}
    <studio-settings :studio="{{$studio}}"></studio-settings>
</section>
@endsection