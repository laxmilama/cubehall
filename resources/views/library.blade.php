@extends('layouts.shop')    

@section('title')
Library
@endsection

@section('content')
<div id="app">
    <div class="container">
        <div class="pt30">
            <div class="">
                <div class="flex-box lb-hd">
                    <h2>History</h2>
                    <a href="{{route('feed.history')}}">All History</a>
                </div>
                <library-history :items="{{$histories}}"></library-history>
            </div>
            <div class="">
                <div class="flex-box lb-hd">
                    <h2>Boards</h2>
                    <a href="{{route('user.board', Auth::user()->slug)}}">All Boards</a>
                </div>
                <div>
                    @foreach ($boards as $board)
                    <div>
                    @if(!is_null($board->thumb))
                        @if($board->thumb->type == "ShowOff")
                        <img src="{{asset('images/showoff/thumb/'.$board->thumb->media)}}" alt="{{$board->name}}">
                        {{$board->name}}
                        @endif
                    @endif
                    </div>
                        
                    @endforeach
                </div>
            </div>
            <div class="">
                <h2>Cart</h2>
            </div>
            <div class="">
                <h2>Reacted</h2>
            </div>
        </div>
    </div>
</div>
@endsection