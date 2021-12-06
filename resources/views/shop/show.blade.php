@extends('layouts.shop')

@section('title')
    Shop products from your favorite creators -
@endsection

@section('content')

    <div class="">
        <div style="">
            @if (count($RecentlyViewedProducts) > 0)
                <div class="mb">
                    <div class="container clearPadMobile">
                        <div class="recent-content">
                            <div class="_MBL-addPad">
                                <h4 class="typography-headline4 thead">Continue Shoping</h4>
                            </div>

                            <div class="recent-content-grid scrollable">
                                @foreach ($RecentlyViewedProducts as $product)
                                    <div class="recent-show-card round_c_s">
                                        <div style="position: relative;">
                                            <div class="recent-showoff-show">
                                                <div class="recent-show-content">
                                                    <a href="{{ route('list', $product->slug) }}">
                                                        <img class="recent-show-img"
                                                            src="{{ asset('images/product/small/' . $product->meta->thumbnail) }}"
                                                            width="100%" alt="{{ $product->name }}">
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
            @endif

            <div class="container" id="app">
                <shop-index></shop-index>
            </div>
        </div>
    </div>

@endsection
