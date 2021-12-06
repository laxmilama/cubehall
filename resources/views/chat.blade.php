@extends('layouts.shop')

@section('title')
    Explore
@endsection

@section('content')
    <div class="container">
        <div data-init="chat">
            <chat-app :user="{{ auth()->user() }}"></chat-app>
        </div>

    </div>
@endsection
