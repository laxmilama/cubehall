@extends('layouts.adminLayout.admin_design')
 @section('content')
 <div class=admin_content_wrapper>
<div data-init="parlor">
      <parlor-upload studio="{{Auth::user()->pages->first()->id}}" creator="{{Auth::user()->id}}"></parlor-upload>
</div>
 @endsection