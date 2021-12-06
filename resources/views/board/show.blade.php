@extends('layouts.shop')

@section('title')
    {{ $board->name }}
@endsection

@section('content')
    <div class="container" id="app">
        <div style="display: inline-block; width:100%;">
            <div>
                <div style="margin-top: 40px; margin-bottom: 40px;" class="_BD_coll">
                    <div class="_BD_profile round_full">
                        <img src="{{ asset('/images/profile/small/' . $owner->profile_image) }}" alt="">
                    </div>

                    <div>
                        <h1 class="_BD_d_title">{{ $board->name }}</h1>
                    </div>
                    <div>
                        <span class="_BD_d_owner"> A board by <a class="_BD_d_handle"
                                href="{{ route('user.show', $owner->slug) }}">@<span
                                    class="_BD_d_handle">{{ $owner->slug }}</span></a></span>
                    </div>
                    <div class="flex-box" style="margin-top:10px;">
                        @if ($board->private != 'true' && count($saves) > 0)
                            @if($saves[0] && $saves[0]->item_type == 'App\\Models\\ShowOff')
                            <board-share owner="{{$board->owner->slug}}" :item="{{ $board }}" board="{{ $board->slug }}" name={{ "$board->name" }}
                                thumbnail="{{ asset('images/showoff/small/' . $saves[0]->media) }}"></board-share>
                            @elseif ($saves[0] && $saves[0]->item_type == 'App\\Models\\ProductList')
                            <board-share owner="{{$board->owner->slug}}" :item="{{ $board }}" board="{{ $board->slug }}" name={{ "$board->name" }}
                                thumbnail="{{ asset('images/product/small/' . $saves[0]->meta->thumbnail) }}"></board-share>
                            @endif
                        @endif
                        @if ($board->is_owner == 'true')
                            <board-option name="{{$board->name}}" slug="{{ $board->slug }}" :privacy={{$board->private}}>
                            </board-option>
                        @endif

                    </div>

                </div>                    
               
                <div class="">
                    <div class="_BD_wrap">
                        @foreach ($saves as $save)
                            <div class="_BD_item round_c_s">
                                <div class="_BD_item_card">
                                    @if ($save->item_type == 'App\\Models\\ProductList')
                                        <a href="/list/{{ $save->slug }}">
                                            <div class="_BD_item_img_holder">
                                                <img class="_BD_item_img"
                                                    src="{{ asset('images/product/small/' . $save->meta->thumbnail) }}"
                                                    alt="">
                                            </div>
                                        </a>
                                    @endif
                                    @if ($save->item_type == 'App\\Models\\ShowOff')
                                        <a href="/showoff/{{ $save->slug }}">
                                            <div class="_BD_item_img_holder">
                                                <img class="_BD_item_img"
                                                    src="{{ asset('images/showoff/small/' . $save->media) }}" alt="">
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
