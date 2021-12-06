@extends('layouts.adminLayout.admin_design')
 @section('content')
 <div class=admin_content_wrapper>
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="app">
      <product-upload></product-upload>
</div>
 @endsection