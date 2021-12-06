@extends('layouts.shop')

@section('title')
    Associate Profile - Site
@endsection

@section('content')
    <div class="mt fix-cont mb-m" style="display: inline-block;">
        <div class="_AS_head container">
            <div class="mb">
                <div class="_AS_h5">
                    <strong>Associate Program</strong>
                </div>
                <h1 class="typography-headline2 _AS_head-t1">Become an associate partner</h1>
                <span class="_AS_content mt-s">Earn commissions recommending products.</span>

            </div>

        </div>
        <div class="sm-container">
            <div class="_AS_illustration">
                <img src="{{asset('assets/undraw_referral_4ki4.svg')}}" alt="">
            </div>

        </div>
        <div class="sm-container ">
            <div class="mt mb" style="display: inline-block; width:100%;">
                <div class="_AS_basic_wrap ">
                    <div class="_AS_basic_card">
                        <div class="_AS_basic_card_ico">
                            <div class="_AS_basic_card_i">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-book-open">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                            </div>
                            <div class="_AS_basic_title">
                                <h2>No application required</h2>
                            </div>
                            <div>
                                <div class="_AS_h5">
                                    You can start earning commissions today. No need to wait for approval.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_AS_basic_card">
                        <div class="_AS_basic_card_ico">
                            <div class="_AS_basic_card_i">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-pie-chart">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                            </div>
                            <div class="_AS_basic_title">
                                <h2>Minimum 5% for each Sale</h2>
                            </div>
                            <div>
                                <div class="_AS_h5">
                                    As an associate, you can earn anywhere from 5%-80% of a sale.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_AS_basic_card">
                        <div class="_AS_basic_card_ico">
                            <div class="_AS_basic_card_i">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-calendar">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="_AS_basic_title">
                                <h2>30 day cookie</h2>
                            </div>
                            <div>
                                <div class="_AS_h5">
                                    If a buyer purchases within 30 days of with your referral link, you bank the commission.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="sm-container">
                <div class="mt mb">
                    <div class="_AS_head">
                        <div>
                            <h1 class="typography-headline3 _AS_head-t1">How does it work?</h1>
                        </div>
                        <div class="_AS_content mt mb">
                            Simply copy affiliate link from the product page and share it to start earning. Anyone with
                            {{ env('APP_NAME') }} account can become an associate partner and start earning right away.

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
                                            Find a product
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Choose the product from five distinct sections that delight your niche
                                                audience. You can find products from the shop menu, explore page, studio
                                                profile, and showoffs curated by buyers.
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
                                            Copy the link and share
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Look for the link icon on the product page. Clicking on the link icon will
                                                automatically generate and copy a unique link, you're ready to promote a
                                                product. These links can be accessed from your <a href="{{route('associate')}}"> associate profile</a>.
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
                                            Earn Money
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Earn commissions for every qualifying purchase made through your associate link. There are no limitations on who can buy. Sell to anyone with online access
                                                around the world.
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
        <div class="_MBL_fix_btm">
            <div class="sm-container">
                <div class="_AS_head">
                    <div>
                        <h1 class="typography-headline3 _AS_head-t1">Get started</h1>
                    </div>
                    <div class="mt-m" style="display: flex; justify-content:center;">
                        <a href="{{ route('feed.shop') }}" class="copyLink btn-normalize bag-btn bag _AS_action">Browse
                            shops</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
