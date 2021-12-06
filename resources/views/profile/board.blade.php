@extends('layouts.shop')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="container clearPadMobile" id="app">
        @include('profile.detail')
        @if (count($boards) > 0)
            <div class="Board_grid _MBL-addPad">
                @foreach ($boards as $board)
                    <div class="Board_card">
                        <a class="_BD" href="{{ route('board.show', $board->slug) }}">
                            <div class="SO_c_holder _BD_multi ">
                                <div class="SO_b_content round_c_m">
                                    <img class="SO_b_img" src="{{ asset($board->thumb) }}"
                                        alt="{{ $board->name }}">
                                </div>
                            </div>

                            <div class="flex-box _BD_title">
                                @if ($board->private == 'true')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="_BD_ico">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                @endif
                                <h3>{{ $board->name }}</h3>
                                <div>
                                    {{ $board->count }} items
                                </div>

                            </div>
                        </a>
                    </div>

                @endforeach
            </div>

        @else
            <div>
                <div class="container">
                    <h1>You haven't saved anything yet.</h1>
                    <p>Use boards to save your wishlist, collection and more. </p>
                </div>
            </div>
        @endif

    </div>
@endsection
