@extends('layouts.shop')

@section('title')
    {{ $product->name }}
    @if ($product->meta->title)
        - {{ $product->meta->title }}
    @endif
@endsection
<?php
$currency = Cookie::get('currency');
?>
@section('content')
    <div class="list-container _LST_fix_btm _MBL_overlap" id="app">
        <div class="container clearPadMobile mb">
            <div class="list-content">
                <div class="list-content-margin list-content-fix-top">
                    <product-bag :product="{{ $product }}" :variant="{{ $metas }}"
                        :user="{{ Auth::user() ? Auth::user()->id : '0' }}" currency="{{ Cookie::get('currency') }}"
                        symbol="{{ Cookie::get('symbol') }}"></product-bag>
                </div>
                <div class="list-content-grid">
                    <div class="list-content-grid-left list-mobile-action _MBL_zind">
                        <div class="_MBL-addPad mobileDisplay">
                            <div class="list-meta">
                                <h3 class="list_product_name ">{{ $product->name }} by
                                    <a href="{{ route('studio', $product->owner->slug) }}">
                                        {{ $product->owner->name }}
                                    </a>
                                </h3>
                            </div>
                            @if ($product->reviews_count)
                                <div>
                                    <div class="flex-box list_rv_count">
                                        <div class="flex-box list_rv_count_counter"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="18" height="18" viewBox="0 0 24 24" fill="#888888"
                                                stroke="currentColor" stroke-width="0" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-star">
                                                <polygon
                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                </polygon>
                                            </svg> <span>{{ $product->ratings_count }}</span>
                                            <span>({{ $product->reviews_count }} reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="_MBL-addPad">
                                <read-more more-str="read more" text="{{ $product->description }}" :max-chars="500">
                                </read-more>
                            </div>
                            <div>
                                <technical-guide :guide="{{ $product->details }}" />
                            </div>
                            @if ($product->tags->count())
                                <div>
                                    <div>
                                        <div class="_MBL-addPad">
                                            <h4 class="typography-headline4 thead">As seen in</h4>
                                        </div>
                                        <div class="_LST_showoff _MBL-addPad">
                                            @foreach ($product->tags as $tagged)
                                                <div class="_LST_showoff_card">
                                                    <div class="showoff-show">
                                                        <div class="showof-show-content">
                                                            <img class="showoff-show-img"
                                                                src="{{ asset('images/showoff/medium/' . $tagged->showoff->media) }}"
                                                                width="100%" alt="{{ $tagged->showoff->title }}">
                                                        </div>
                                                        <a href="{{ route('showoff.show', $tagged->showoff->slug) }}"
                                                            class="list_link"></a>
                                                    </div>
                                                    <div class="showoff-shop-tag p-helper round_c_b">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-tag">
                                                            <path
                                                                d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                                                            </path>
                                                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                                        </svg>
                                                        <span>Shop All</span>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div>
                                            @if ($product->total_tags > 4)
                                                {{ $product->total_tags }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($product->reviews->count() > 0)
                            <div class="review-wrapper mt _MBL-addPad">
                                <div class="review-summery mb-m">
                                    <div class="review-summery-header">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="#888888" stroke="currentColor" stroke-width="0"
                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                <polygon
                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                </polygon>
                                            </svg>
                                        </div>
                                        <div class="typography-headline5">
                                            <span>{{ $product->ratings_count }} ({{ $product->reviews_count }}
                                                reviews)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="review_container">
                                    {{-- {{dd($parlor->reviewsTop)}} --}}
                                    @foreach ($product->reviews as $review)
                                        <div class="review_wrapper review_grid">
                                            <div class="review_wt">
                                                <div class="review_pp">
                                                    <img class="review_pp_img"
                                                        src="{{ asset('images/profile/thumb/' . $review->writer->profile_image) }}"
                                                        alt="{{ $review->writer->name }}">
                                                </div>
                                                <div class="review_wt_dt">
                                                    <span class="review_wt_n">{{ $review->writer->name }}</span>
                                                    <div class="review_wt_t">
                                                        {{ date('F, Y', strtotime($review->created_at)) }}
                                                    </div>
                                                    <div>
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $review->rating) <svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    style="fill:var(--primary-color);
                                                                                                                stroke:var(--primary-color)">
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14
                                                                                                                18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27
                                                                                                                8.91 8.26 12
                                                                                                                2">
                                                                    </polygon>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    style="stroke:var(--primary-color)">
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14
                                                                                                                18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27
                                                                                                                8.91 8.26 12
                                                                                                                2">
                                                                    </polygon>
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <slot>
                                                <read-more more-str="read more" text="{{ $review->review }}"
                                                    less-str="read less" :max-chars="190"></read-more>
                                            </slot>

                                        </div>
                                    @endforeach
                                </div>
                                @if ($product->reviews_count > 4)
                                    <all-product-review product="{{ $product->slug }}"
                                        :rating="{{ $product->ratings_count }}"
                                        :count="{{ $product->reviews_count }}" />
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if (count($similarProducts) > 0)
            <div class="mb">
                <div class="container clearPadMobile">
                    <div class="recent-content">
                        <div class="_MBL-addPad">
                            <h4 class="typography-headline4 thead">Suggestions</h4>
                        </div>

                        <div class="recent-content-grid scrollable _MBL-addPad">
                            @foreach ($similarProducts as $product)
                                <product-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                                    local="{{ Cookie::get('currency') }}" currency="{{ $product->meta->currency }}"
                                    title="{{ $product->meta->title }}" name="{{ $product->name }}"
                                    thumbnail="{{ $product->meta->thumbnail }}" slug="{{ $product->slug }}"
                                    amount="{{ $product->meta->price }}" ratings_count="{{ $product->ratings_count }}"
                                    reviews_count="{{ $product->reviews_count }}">
                                </product-card>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @endif

        

        @if ($RecentlyViewedProducts != null)
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

        @if (count($similarProducts) > 0)
            <div class="mb mt">
                <div class="container clearPadMobile">
                    <div class="recent-content">
                        <div class="_MBL-addPad std_ownr_wrap">
                            <div class="flex-box">
                                <div class="std_ownr_profile round_full">
                                    <img class="std_ownr_profile_img"
                                        src="{{ asset('images/profile/thumb/' . $product->owner->profile_image) }}"
                                        alt="">
                                </div>
                                <div>
                                    <div>
                                        <h4 class="typography-headline4 thead">{{ $product->owner->name }}</h4>
                                        <h4 class="studio_handle">{{ '@' . $product->owner->slug }} </h4>
                                    </div>
                                    <div class="flex-box">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="#888888" stroke="currentColor" stroke-width="0"
                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                                <polygon
                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                </polygon>
                                            </svg>
                                            <span>
                                                {{ $product->owner->studio_rating }} ({{ $product->owner->reviews_count }}
                                                reviews)
                                            </span>
                                        </div>
                                        <div>
                                            <span>

                                            </span>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="recent-content-grid scrollable _MBL-addPad">
                            @foreach ($similarProducts as $product)
                                <product-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                                    local="{{ Cookie::get('currency') }}" currency="{{ $product->meta->currency }}"
                                    title="{{ $product->meta->title }}" name="{{ $product->name }}"
                                    thumbnail="{{ $product->meta->thumbnail }}" slug="{{ $product->slug }}"
                                    amount="{{ $product->meta->price }}" ratings_count="{{ $product->ratings_count }}"
                                    reviews_count="{{ $product->reviews_count }}">
                                </product-card>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>
@endsection
