@extends('layouts.chat')

@section('title')
    Messages
@endsection

@section('content')
    <div class="container clearPadMobile">
        <div data-init="chat">
            <chat-app :user="{{ auth()->user() }}"></chat-app>
        </div>

    </div>
@endsection
