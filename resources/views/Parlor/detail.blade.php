@extends('layouts.adminLayout.admin_design')

@section('title')
    Parlors
@endsection
@section('content')

    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="sm-container" id="app">
            <parlor-details :parlor="{{ $detail }}"></parlor-details>
        </div>
    </div>
@endsection
