@extends('layouts.helper')

@section('title')
    CubeHall online studio
@endsection

@section('content')
    <div class="mb fix-cont "" style=" display: inline-block;">
        <div class="container">
            <div class="mt">
                <a href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="studio_logo"
                        viewBox="0 0 20.36 20.34">
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="Layer_1-2" data-name="Layer 1">
                                <path
                                    d="M9.4,20.34H1.79A1.79,1.79,0,0,1,0,18.55v-7.7A2.65,2.65,0,0,1,2.65,8.2H4.12a2.73,2.73,0,0,1,2.73,2.73V13a.5.5,0,0,0,.5.49h2a2.74,2.74,0,0,1,2.74,2.74v1.39A2.72,2.72,0,0,1,9.4,20.34ZM2.65,9.49A1.36,1.36,0,0,0,1.3,10.85v7.7a.5.5,0,0,0,.49.5H9.4a1.43,1.43,0,0,0,1.43-1.43V16.23a1.44,1.44,0,0,0-1.44-1.44h-2A1.79,1.79,0,0,1,5.56,13V10.93A1.45,1.45,0,0,0,4.12,9.49Z" />
                                <path
                                    d="M15.09,20.34a1.66,1.66,0,0,1-.61-.12,1.59,1.59,0,0,1-1-1.47V7.14a.29.29,0,0,0-.29-.29H1.61A1.58,1.58,0,0,1,.49,4.14L4.17.46A1.62,1.62,0,0,1,5.29,0H18.77a1.59,1.59,0,0,1,1.59,1.59V15.08a1.6,1.6,0,0,1-.47,1.12l-3.68,3.68A1.59,1.59,0,0,1,15.09,20.34Zm-9.8-19a.32.32,0,0,0-.21.08L1.41,5.06a.3.3,0,0,0-.07.32.29.29,0,0,0,.27.18h11.6A1.59,1.59,0,0,1,14.8,7.14V18.75A.28.28,0,0,0,15,19a.26.26,0,0,0,.31-.06L19,15.28a.3.3,0,0,0,.08-.2V1.59a.29.29,0,0,0-.29-.29Z" />
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <div class="_AS_head container">
            <div class="mb">
                <div class="_AS_h5">
                    <strong>Cubehall Studio</strong>
                </div>
                <h1 class="typography-headline2 _AS_head-t1">Made possible by creators.</h1>
                <span class="_AS_content mt-s">Join creators comunity at CubeHall</span>

                <div class="mt-m" style="display: flex; justify-content:center;">
                    <a href="{{ route('studio.create') }}" class="btn-gdnt btn-normalize">Get Started </a>
                </div>

            </div>

        </div>
        <div class="sm-container">
            <div class="_AS_illustration">
                <img src="{{ asset('assets/undraw_referral_4ki4.svg') }}" alt="">
            </div>

        </div>
        <div class="mt">
            <div class="sm-container">
                <div class="mt mb">
                    <div class="_AS_head">
                        <div>
                            <h1 class="typography-headline2 _AS_head-t1">What is CubeHall studio?</h1>
                        </div>
                        <div class="_AS_content mt mb">
                            CubeHall studio helps you become a creative entrepreneur enabling you to sell anything, get
                            commissioned, or even host online activities. Where you can turn your hobbies into extra income.

                        </div>

                    </div>
                </div>
                <div>
                    <div class="mt mb">
                        <div class="_AS_how_wrap">
                            <div class="_AS_how_body">
                                <div class="_AS_how_img_container round_c_m">
                                    <img src="{{ asset('assets/affiliate_products.png') }}" alt="">
                                </div>
                                <div class="_AS_how_content">
                                    <div>
                                        <div class="_AS_how_card_title">
                                            Show it. Sell it.
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Stop rolling the dice of ads in the hope of better conversion. We’re
                                                building a better place to create and buy. Join us and find your best
                                                audience.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_AS_how_body">
                                <div class="_AS_how_img_container round_c_m">
                                    <img src="{{ asset('assets/affiliate_link.png') }}" alt="">
                                </div>
                                <div class="_AS_how_content">
                                    <div>
                                        <div class="_AS_how_card_title">
                                            You have 100% ownership
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                You have total control over your followers and shoppers. Email or make a
                                                call it's up to you.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_AS_how_body">
                                <div class="_AS_how_img_container round_c_m">
                                    <img src="{{ asset('assets/affiliate_paid.png') }}" alt="">
                                </div>
                                <div class="_AS_how_content">
                                    <div>
                                        <div class="_AS_how_card_title">
                                            No ads, no trolls.
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Forget algorithms and enjoy a direct, meaningful connection with the people
                                                who matter the most. We ensure to deliver your content to every follower you
                                                have. Reach new people and boost your online presence with zero ad.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sm-container ">
            <div class="mt mb" style="display: inline-block; width:100%;">
                <div class="_AS_head mb-m">
                    <div>
                        <h1 class="typography-headline3 _AS_head-t1">Some common questions</h1>
                    </div>
                </div>
                <div class="_AS_basic_wrap ">
                    <div class="_AS_basic_card">
                        <div class="_AS_basic_card_ico">
                            <div class="_AS_basic_title">
                                <h2>Why should I create CubeHall studio?</h2>
                            </div>
                            <div>
                                <div class="_AS_h5">
                                    Studio helps brands and creators to set up shop, host parlor or do both. The studio is where
                                    you can start monetizing your passion. You'll also get access to analytics. It’s free
                                    and takes less than a minute.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_AS_basic_card">
                        <div class="_AS_basic_card_ico">
                            <div class="_AS_basic_title">
                                <h2>How do I get started on CubeHall?</h2>
                            </div>
                            <div>
                                <div class="_AS_h5">
                                    Thanks for asking. First, <a href="{{route('register')}}"> register a personal account</a>. Then, you can <a href="{{route('studio.create')}}">create a studio </a>
                                    and use our tools and features to grow your audience.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_AS_basic_card">
                        <div class="_AS_basic_card_ico">
                            <div class="_AS_basic_title">
                                <h2>How do I fit in?</h2>
                            </div>
                            <div>
                                <div class="_AS_h5">
                                    Studio helps brands and creators to list products and host parlor. The studio is where
                                    you can start monetizing your passion. You'll also get access to analytics. It’s free
                                    and takes less than a minute.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt">
            <div class="sm-container">
                <div class="_AS_head">
                    <div>
                        <h1 class="typography-headline3 _AS_head-t1">Creators, it’s your time to shine.</h1>
                    </div>
                    <div class="mt-m" style="display: flex; justify-content:center;">
                        <a href="{{ route('studio.create') }}" class="copyLink btn-normalize bag-btn bag _AS_action">Start
                            your studio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
