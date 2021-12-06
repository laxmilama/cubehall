@extends('layouts.shop')

@section('title')
{{ $parlor->title }} | Parlor
@endsection

@section('content')
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <div class="parlor-container _MBL_overlap">
        <div class="container clearPadMobile">
            <div class="parlor-content">
                <div class="parlor-content-grid">
                    <div class="parlor-content-grid-left">
                        <div class="parlor-top">
                            <div class="mbPad mobileDisplay">
                                <div>
                                    <h1>{{ $parlor->title }}</h1>
                                </div>
                                <div class="flex-box">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            style="fill:var(--primary-color); stroke:var(--primary-color)">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg>
                                    </div>
                                    <div class="">
                                        <span>{{ $parlor->star_count }} ({{ $parlor->reviews_count }} reviews)</span>
                                    </div>

                                </div>
                            </div>
                            <div class="_PLR_slide">
                                <div class="_PLR_flx" data-init="back-button">

                                    <div id="videoContainer" data-fullscreen="false">
                                        <video class="_PLR_video" id="video" playsinline style="pointer-events: none;" controls preload="metadata"
                                            poster="{{ asset('images/parlor/medium/' . $parlor->cover) }}" autoplay loop
                                            muted>
                                            <source src="{{ asset('videos/' . $parlor->video) }}" type="video/mp4">
                                        </video>
                                        <div id="video-controls" class="controls" data-state="hidden">
                                            <div>
                                                <button id="playpause" type="button" data-state="play">Play/Pause</button>
                                                <button id="mute" type="button" data-state="mute">Mute/Unmute</button>
                                            </div>
                                            <div class="progress">
                                                <progress id="progress" value="0" min="0">
                                                    <span id="progress-bar"></span>
                                                </progress>
                                            </div>
                                            <div>
                                                <button id="fs" type="button" data-state="go-fullscreen">Fullscreen</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="parlor-images">
                                        @foreach (json_decode($parlor->details) as $detail)
                                            <img src="{{ asset('images/parlor/medium/' . $detail) }}" alt="">

                                        @endforeach
                                    </div>
                                    <back-button></back-button>
                                </div>
                            </div>
                        </div>
                        <div class="mbPad">
                            <div>
                                <div>
                                    <h2>Parlor Hosted by <a class="profile-handle"
                                            href="/{{ $parlor->owner->slug }}">{{ '@' . $parlor->owner->slug }}</a>
                                    </h2>
                                    <div>
                                        <span>{{ $parlor->ticket->duration }} min </span>
                                        <span> · </span>
                                        @if (count(json_decode($parlor->languages)) >= 1)
                                            <span> Hosted in
                                                
                                                @foreach (json_decode($parlor->languages) as $language)
                                                    {{ $language }},
                                                @endforeach
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <p>{{ $parlor->brief }}</p>
                                <div>
                                    <ul>
                                        @foreach (json_decode($parlor->learnings) as $learning)
                                            <li>{{ $learning }}</li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="parlor-brief">
                                <div>
                                    <h2>What to bring</h2>
                                    <div>
                                        <ul class="parlor-list">
                                            @foreach (json_decode($parlor->bringings) as $bringing)
                                                <li>
                                                    <div class="parlor-list-l">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-check-circle">
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                        </svg>

                                                    </div>


                                                    <span> {{ $bringing }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="parlor-brief">
                                <div class="divider-bar mt-m mb-m"></div>
                                <div>
                                    <h2>How to participate</h2>
                                    <div class="parlor-how">
                                        <div class="round_c_s parlor-how-card">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-monitor">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g id="ic_fluent_ticket_24_regular" fill="#212121"
                                                            fill-rule="nonzero">
                                                            <path
                                                                d="M20.25,5 C21.2164983,5 22.0001346,5.78350169 22.0001346,6.74995533 L22.0001346,9.01021267 C22.0001346,9.40054809 21.7007807,9.72564523 21.3117654,9.75772081 C20.1511509,9.85341727 19.25,10.8272636 19.25,12 C19.25,13.1727364 20.1511509,14.1465827 21.3117654,14.2422792 C21.7007807,14.2743548 22.0001346,14.5994519 22.0001346,14.9897873 L22.0001346,17.25 C22.0001346,18.2164983 21.2164983,19 20.25,19 L3.75,19 C2.78350169,19 2,18.2164983 2,17.2499032 L2.0002918,14.9896106 C2.00034218,14.5993704 2.29963917,14.2743756 2.68855505,14.2422527 C3.84902655,14.1464025 4.75,13.1726173 4.75,12 C4.75,10.8273827 3.84902655,9.85359752 2.68855505,9.75774726 C2.29963917,9.72562438 2.00034218,9.40062959 2.0002918,9.01038935 L2,6.75 C2,5.78350169 2.78350169,5 3.75,5 L20.25,5 Z M20.5000974,8.38474434 L20.5000974,6.75 C20.5000974,6.61192881 20.3880712,6.5 20.25,6.5 L3.75,6.5 C3.61192881,6.5 3.49999999,6.61192881 3.49999999,6.74990318 L3.50021106,8.38482947 C5.0931294,8.82405937 6.25,10.2839928 6.25,12 C6.25,13.7160072 5.0931294,15.1759406 3.50021105,15.6151705 L3.49999999,17.25 C3.49999999,17.3880712 3.61192881,17.5 3.75,17.5 L20.25,17.5 C20.3880712,17.5 20.5000974,17.3880712 20.5000974,17.2499553 L20.5000974,15.6152557 C18.9070334,15.1761323 17.75,13.7161326 17.75,12 C17.75,10.3525127 18.816322,8.94107753 20.3110688,8.44229041 L20.5000974,8.38474434 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3>Book your place.</h3>
                                                <p>
                                                    Book {{ $parlor->owner->name }}'s parlor and confirm your seat before
                                                    it's too late.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="round_c_s parlor-how-card">
                                            <div>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-monitor">
                                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3>Join video call</h3>
                                                <p>
                                                    After booking, you will receive detail on how to join. You will have to
                                                    use either zoom or jitsi on your device.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-m mb-m">
                                    <div class="flex-box" style="align-items: center">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shield" style="margin-right: 6px">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="typography-caption">To protect your payment, never transfer money outside of the CubeHall website or app.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($parlor->reviewsTop) > 0)
                            <div class="review mt" id="app">
                                <div class="review-wrapper _MBL-addPad">
                                    <div class="review-summery">
                                        <div class="review-summery-header review_sum">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    style="fill:var(--primary-color); stroke:var(--primary-color)">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                            </div>
                                            <div class="typography-headline5">
                                                <span>{{ $parlor->star_count }} / 5
                                                    ({{ $parlor->reviews_count }}
                                                    Reviews)</span>
                                            </div>
                                        </div>
                                        <div class="review_container">
                                            {{-- {{dd($parlor->reviewsTop)}} --}}
                                            @foreach ($parlor->reviewsTop as $review)
                                                <div class="review_wrapper review_grid">
                                                    <div class="review_wt">
                                                        <div class="review_pp">
                                                            <img class="review_pp_img"
                                                                src="{{ asset('images/profile/thumb/' . $review->writer->profile_image) }}"
                                                                alt="{{ $review->writer->name }}">
                                                        </div>
                                                        <div class="review_wt_dt">
                                                            <span
                                                                class="review_wt_n">{{ $review->writer->name }}</span>
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
                                                                            <polygon
                                                                                points="12 2 15.09 8.26 22 9.27 17 14.14
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
                                                                            <polygon
                                                                                points="12 2 15.09 8.26 22 9.27 17 14.14
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
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <?php if (Auth::check()) {
                        $id = Auth::user()->id;
                    } else {
                        $id = 0;
                    }
                    
                    ?>
                    <div class="parlor-content-grid-right">
                        <div class="parlor-content-margin" data-init="parlorbook">
                            <parlor-book :parlor="{{ $parlor }}" :userid={{ $id }}
                                currency="{{ Cookie::get('currency') }}" symbol="{{ Cookie::get('symbol') }}">
                            </parlor-book>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-m">
                <div class="more-header">
                    <h2 class="txt-wt typography-headline5">More parlors</h2>
                    <a href="{{ route('explore.parlors') }}" class="btn-secondary btn-normalize">See all
                        Parlors</a>
                </div>
                <div class="parlor-more-wrapper scrollable">
                    @foreach ($parlors as $item)
                        <div class="parlor-card">
                            <div class="explore-parlor-list" style="width:100%;">
                                <div class="parlor-card-box round_c_s">
                                    <img class="parlor-card-box-img"
                                        src="{{ asset('images/parlor/small/' . $item->cover) }}" alt="">
                                </div>

                                <div class="explore-parlor-name">
                                    <span class="typography-headline6 title">{{ $item->title }}</span>

                                    <div>
                                        <span class="typography-body2 meta">

                                            @if ($item->reviews_count > 0)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="#888888" stroke="currentColor"
                                                    stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-star">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                                {{ $item->star_count }} ({{ $item->reviews_count }})
                                            @endif

                                            {{ $item->location }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="typography-headline6 cost">{{ $item->ticket->price }}</span> /
                                        person
                                    </div>
                                </div>
                                <a class="parlor-link" href="{{ route('parlor.show', $item->slug) }}"></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection
