@extends('layouts.shop')

@section('title')
    Showoff your collection
@endsection

@section('content')
<style>
    ._AS_Pic{
        width: 100%;
        
    }
    ._AS_Pic_img{
        width: 100%;
        
    }
</style>
    <div class="mt fix-cont mb-m" style="display: inline-block;">
        <div class="_AS_head container">
            <div class="mb">
                <div class="_AS_h5">
                    <strong>Showoff</strong>
                </div>
                <h1 class="typography-headline2 _AS_head-t1">Flex your collections</h1>
                <span class="_AS_content mt-s">Earn money every time someone buys a product referred by your showoff.</span>
            </div>

        </div>
        <div class="sm-container">
            <div class="_AS_Pic">
                <img class="_AS_Pic_img" src="{{ asset('assets/statics/rob-brink-cPJP5MY83U0-big.jpg') }}" alt="">
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
                            After verifying your account and wallet or bank information, the Showing off feature will be
                            enabled automatically. Create attractive images using the product and tag your bought products.
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
                                            Buy product
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
                                    <img src="{{ asset('assets/delivery.png') }}" alt="">
                                </div>
                                <div class="_AS_how_content">
                                    <div>
                                        <div class="_AS_how_card_title">
                                            Wait for Delivery
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Only the products that are successfully delivered to you can be tagged in
                                                your showoff.
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
                                            Create & Share
                                        </div>
                                        <div class="_AS_how_text">
                                            <p>
                                                Earn commissions for every qualifying purchase made through your showoff
                                                tags. There are no limitations on who can buy. Sell to anyone with online
                                                access around the world.
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
