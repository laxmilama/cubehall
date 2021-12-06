@extends('layouts.shop')

@section('title')
    {{ $showoff->title }}
@endsection

@section('content')
    <?php
    if (Cookie::has('currency')) {
        $c = Cookie::get('currency');
    } else {
        $c = 'NPR';
    }
    
    if (Cookie::has('symbol')) {
        $s = Cookie::get('symbol');
    } else {
        $s = 'Rs.';
    }
    
    ?>
    <div id="app" class="_MBL_overlap">
        <div class="sm-container clearPadMobile">
            <div class="dmt mb-s" style="width:100%;">
                <div class="d-flx-showoff">
                    <div class="showoff-img-wrap">
                        <img class="image_point showoff-img round_c_s"
                            src="{{ asset('images/showoff/medium/' . $showoff->media) }}" alt="">
                        @if (count($showoff->tagged) > 0)


                            @foreach ($showoff->tagged as $tag)
                                {{-- {{dd($tag->product->meta->title)}} --}}
                                <div id="tagged" class="tag"
                                    style="top: {{ $tag->top }}; left: {{ $tag->left }}; visibility: visible">
                                    @if ((int) $tag->left < 20)
                                        @if ((int) $tag->top < 20)
                                            <div class="tagged-product" style="">
                                                <div class="p-tagged" style="padding-left:25px; left:0; top: -15px;">
                                                    <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                                        local="{{ $c }}"
                                                        currency="{{ $tag->product->meta->currency }}"
                                                        name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                                        amount="{{ $tag->product->meta->price }}"
                                                        product="{{ $tag->product->slug }}"></product-tag>
                                                </div>

                                            </div>


                                        @elseif((int)$tag->top > 20 && (int)$tag->top <80) <div class="tagged-product"
                                                style="">
                                                <div class="p-tagged"
                                                    style="padding-left: 25px; left: 0; top: -15px;">
                                                    <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                                        local="{{ $c }}"
                                                        currency="{{ $tag->product->meta->currency }}"
                                                        name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                                        amount="{{ $tag->product->meta->price }}"
                                                        product="{{ $tag->product->slug }}"></product-tag>
                                                </div>
                                </div>
                            @else
                                <div class="tagged-product" style="">
                                    <div class="p-tagged" style="bottom: -15px; padding-left: 25px; left:0;">
                                        <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                            local="{{ $c }}" currency="{{ $tag->product->meta->currency }}"
                                            name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                            amount="{{ $tag->product->meta->price }}"
                                            product="{{ $tag->product->slug }}">
                                        </product-tag>
                                    </div>
                                </div>
                                @endif @elseif((int)$tag->left > 20 && (int)$tag->left <80) @if ((int) $tag->top < 20)
                                    <div class="tagged-product" style="">
                                        <div class="p-tagged"
                                            style="transform: translateX(-50%);  padding-top: 25px; top:0;">
                                            <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                                local="{{ $c }}"
                                                currency="{{ $tag->product->meta->currency }}"
                                                name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                                amount="{{ $tag->product->meta->price }}"
                                                product="{{ $tag->product->slug }}"></product-tag>
                                        </div>
                                    </div>

                                @elseif((int)$tag->top > 20 && (int)$tag->top <80) <div class="tagged-product" style="">
                                        <div class="p-tagged"
                                            style="transform: translateX(-50%); padding-top: 25px; top:0;">
                                            <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                                local="{{ $c }}"
                                                currency="{{ $tag->product->meta->currency }}"
                                                name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                                amount="{{ $tag->product->meta->price }}"
                                                product="{{ $tag->product->slug }}"></product-tag>
                                        </div>
                    </div>
                @else
                    <div class="tagged-product" style="">
                        <div class="p-tagged" style="transform: translateX(-50%); padding-bottom: 25px; bottom: 0px;">
                            <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                local="{{ $c }}" currency="{{ $tag->product->meta->currency }}"
                                name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                amount="{{ $tag->product->meta->price }}" product="{{ $tag->product->slug }}">
                            </product-tag>
                        </div>
                    </div> @endif @else @if ((int) $tag->top < 20)

                        <div class="tagged-product">
                            <div class="p-tagged" style="top: -15px;  padding-right: 25px; right:0;">
                                <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                    local="{{ $c }}" currency="{{ $tag->product->meta->currency }}"
                                    name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                    amount="{{ $tag->product->meta->price }}" product="{{ $tag->product->slug }}">
                                </product-tag>
                            </div>
                        </div>

                    @elseif((int)$tag->top > 20 && (int)$tag->top <80) <div class="tagged-product" style="">
                            <div class="p-tagged" style="padding-right: 25px; right:0; top: -15px;">
                                <product-tag rates="{{ $rates }}" symbol="{{ $s }}"
                                    local="{{ $c }}" currency="{{ $tag->product->meta->currency }}"
                                    name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                                    amount="{{ $tag->product->meta->price }}" product="{{ $tag->product->slug }}">
                                </product-tag>
                            </div>
                </div>
            @else
                <div class="tagged-product" style="">
                    <div class="p-tagged" style="bottom: -15px; padding-right: 25px; right:0">
                        <product-tag rates="{{ $rates }}" symbol="{{ $s }}" local="{{ $c }}"
                            currency="{{ $tag->product->meta->currency }}" name="{{ $tag->product->name }}"
                            slug="{{ $showoff->slug }}" amount="{{ $tag->product->meta->price }}"
                            product="{{ $tag->product->slug }}"></product-tag>
                    </div>
                </div>
                @endif
                @endif
            </div>

            @endforeach
            @endif
            <figure data-init="back" class="mobileDisplay btn-back">
                <div onclick="goBack()" class="sticky btn-back-inside">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </div>
            </figure>
        </div>
        <div class="showoff_brief mbPad">
            @auth


                <div class="_SO_flx_act">
                    <div style="display: flex;">
                        <show-off-react :item="{{ $showoff }}"></show-off-react>
                        <show-off-comment :showoff="{{ $showoff }}" :viewer="{{ Auth::user() }}"></show-off-comment>
                        <show-off-save :item="{{ $showoff }}" :btn="true"></show-off-save>
                    </div>
                    <div style="display: flex;">
                        <share-button thumbnail="{{ $showoff->media }}" title="{{ $showoff->title }}"
                            slug="{{ $showoff->slug }}" owner="{{ $showoff->owner->slug }}"
                            brief="{{ $showoff->description }}"></share-button>
                        <div>
                            <show-off-option is_owner="{{$showoff->is_owner}}" slug="{{ $showoff->slug }}"></show-off-option>                            
                        </div>
                    </div>
                </div>
            @endauth
            <div>
                <div>
                    <h1 class="_SO_head">{{ $showoff->title }}</h1>
                    <p class="SO_desc">
                        {{ $showoff->description }}
                    </p>
                </div>
            </div>
            <div>
                @if (count($showoff->tagged) > 0)
                    @foreach ($showoff->tagged as $tag)
                        <product-side-tag rates="{{ $rates }}" symbol="{{ $s }}"
                            local="{{ $c }}" currency="{{ $tag->product->meta->currency }}"
                            name="{{ $tag->product->name }}" slug="{{ $showoff->slug }}"
                            amount="{{ $tag->product->meta->price }}" product="{{ $tag->product->slug }}"
                            title="{{ $tag->product->meta->title }}" thumbnail="{{ $tag->product->meta->thumbnail }}">
                        </product-side-tag>

                    @endforeach
                @endif
            </div>
            <div class="_SO_owner">
                <div class="flex-box">
                    <div class="flex-box _SO_FLX_OWN">
                        <div class="_SO_profile round_full">
                            <a href="{{ route('user.show', $showoff->owner->slug) }}">
                                <img src="{{ asset('images/profile/thumb/' . $showoff->owner->profile_image) }}" alt="">
                            </a>
                        </div>
                        <div>
                            <div>
                                <a class="_SO_link" href="{{ route('user.show', $showoff->owner->slug) }}">
                                    {{ $showoff->owner->name }}
                                </a>
                            </div>
                            <div class="_SO_follower_counter">
                                {{ $showoff->owner->followers_count }} followers
                            </div>

                        </div>
                        <div data-init="follow-user-basic">
                            <follow-user-basic pid="{{ $showoff->owner->id }}"
                                is_following="{{ $showoff->owner->is_followed }}"></follow-user-basic>
                            {{-- <follow-user pid="{{$showoff->owner->id}}" slug="{{$showoff->owner->slug}}" is_following="{{$showoff->owner->is_followed}}"></follow-user> --}}
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    </div>
    <div class="divider-bar"></div>

    </div>

    <div class="container">
        <div>
            <div style="display: inline-block;  width:100%;">
                <div class="mt">
                    <h1 class="typography-headline4 thead">
                        More like this
                    </h1>
                    <div style="position: relative">
                        <div class="showoff-show-wrapper">
                            @foreach ($similar as $show)

                                <div class="showoff-show-card round_c_s">
                                    <div style="position: relative;">
                                        <div class="showoff-show">
                                            <div class="showof-show-content">
                                                <a href="/showoff/{{ $show->slug }}">
                                                    <img class="showoff-show-img"
                                                        src="{{ asset('images/showoff/medium/' . $show->media) }}"
                                                        width="100%" alt="{{ $show->title }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
