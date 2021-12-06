@extends('layouts.shop')

@section('title')
{{$user->name}}
@endsection

@section('content')
    <div id="app">
        @include('profile.detail')
        @if (count($showoffs) > 0)
            <div class="container clearPadMobile">
                <profile-showoff :showoffs="{{ $showoffs }}"></profile-showoff>
            </div>
        @else
            <div>
                <div class="container ">
                    <h1>You haven't created any showoffs yet. </h1>
                    <p>Buy products to create showoffs.</p>
                </div>
            </div>

        @endif
    </div>
@endsection
