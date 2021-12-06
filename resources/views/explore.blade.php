@extends('layouts.shop')

@section('title')
    Explore
@endsection

@section('content')
    @auth
        <div class="container clearPadMobile">
            <div data-init="story" class="_MBL-addPad mb">
                <discover-creators></discover-creators>
                <discover :viewer="{{ Auth::user() }}"></discover>
            </div>
        </div>
    @endauth
    <div id="app" class="explore _MBL_fix_btm">
        <div class="container clearPadMobile">
            <div class="explore-studio mb" data-init="top-creators">
                <div class="header _MBL-addPad">
                    <h2 class="txt-wt typography-headline5">Top Creators</h2>
                </div>
                <div class="explore-studio-wrapper _MBL-scroll">
                    @for ($i = 0; $i < count($studios); $i++)
                        @if ($i % 3 == 0)
                            <div class="explore-studio-card _MBL-scroll">
                                @for ($j = $i; $j < $i + 3; $j++)
                                    @if ($j < count($studios))
                                        <div class="flex-box explore-studio-box">
                                            <div class="explore-studio-num">
                                                <span>{{ $j + 1 }}</span>
                                            </div>
                                            <div class="explore-studio-list">
                                                <div class="explore-img round_c_s">
                                                    <a href="{{ $studios[$j]->slug }}">
                                                        <img src="{{ asset('/images/profile/small/' . $studios[$j]->profile_image) }}"
                                                            alt="{{ $studios[$j]->name }}">
                                                    </a>
                                                </div>
                                                <div class="explore-studio-n-wrap">
                                                    <a class="explore-studio-name" href="{{ $studios[$j]->slug }}">
                                                        <span>{{ $studios[$j]->name }}</span>
                                                    </a>
                                                    <div>
                                                        <span class="explore-studio-counter">
                                                            {{ $studios[$j]->followers_count }} Followers</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
            <div class="mt-m mb ">
                <div class="more-header _MBL-addPad">
                    <h2 class="txt-wt typography-headline5">Top parlors</h2>
                    <a href="{{ route('explore.parlors') }}" class="btn-secondary btn-normalize">See all
                        Parlors</a>
                </div>
                <div class="parlor-more-wrapper scrollable _MBL-addPad">
                    @foreach ($parlors as $item)
                        <parlor-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                            local="{{ Cookie::get('currency') }}" currency="{{ $item->ticket->currency }}"
                            title="{{ $item->title }}" thumbnail="{{ $item->cover }}" slug="{{ $item->slug }}"
                            amount="{{ $item->ticket->price }}" star_count="{{ $item->star_count }}"
                            reviews_count="{{ $item->reviews_count }}" location="{{ $item->location }}"
                            available="{{ $item->ticket->is_available }}"
                            parlor="{{$item->id}}" parent="{{$item->owner->id}}" type="{{$item->type}}"
                            >

                        </parlor-card>
                    @endforeach
                </div>
            </div>

            <div class="explore-product mt mb">
                <div class="header _MBL-addPad">
                    <div>
                        <h4 class="typography-headline4 thead">Best selling products</h4>
                    </div>
                    <a href="{{ route('category.all') }}" class="btn-secondary btn-normalize">See all Products</a>
                </div>
                <div class="explore-product-wrapper scrollable _MBL-addPad">
                    @foreach ($products as $product)
                        <product-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                            local="{{ Cookie::get('currency') }}" currency="{{ $product->meta->currency }}"
                            title="{{ $product->meta->title }}" name="{{ $product->name }}"
                            thumbnail="{{ $product->meta->thumbnail }}" slug="{{ $product->slug }}"
                            amount="{{ $product->meta->price }}" ratings_count="{{ $product->ratings_count }}"
                            reviews_count="{{ $product->reviews_count }}" product="{{$product->id}}" parent="{{$product->owner->id}}" type="{{$product->item_type}}">
                        </product-card>
                    @endforeach
                </div>
            </div>


            <div class="explore-exp mb" style="display: flex; flex-direction: column; width:100%">
                <div class="_MBL-addPad">
                    <h4 class="typography-headline4 thead">Trending</h4>
                </div>
                <trending-product rates="{{ $c }}" currency="{{ Cookie::get('currency') }}" symbol="{{ Cookie::get('symbol') }}">
                </trending-product>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.onbeforeunload = function() {
            //  return 'Are you really want to perform the action?';
        }
    </script>
@endsection
