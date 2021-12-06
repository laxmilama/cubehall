@extends('layouts.shop')

@section('title')
    Shop original from independent creators and brands
@endsection

@section('content')
    @if (!Auth::user())
        @if (!session()->has('onetap'))
            <div id="g_id_onload" data-client_id="379390375312-0kgq4587gqsnn4f1qj0nvcvlcro1r77d.apps.googleusercontent.com"
                data-login_uri="{{ route('google1.callback') }}" data-auto_select="true"
                data-_token="{{ csrf_token() }}">
            </div>
            {{ session()->put('onetap', 'shown') }}
        @endif
    @endif
    <div class="banner">
        <div class="banner-wrapper">
            <div class="banner-centered">
                <img class="banner-pic" src="{{ asset('assets/statics/Orluna_Residential_03_020819.jpg') }}" alt="">
            </div>
        </div>
    </div>
    <div class="home-category">
        <div class="home-category-wrapper container mb">
            <div class="home-category-card round_c_m">
                <div class="home-category-card-groups scroll_Cat">
                    @foreach ($category as $cat)
                        <div class="home-category-group">
                            <h4>{{ $cat->name }}</h4>
                            @if (!is_null($cat->categories))
                                <ul>
                                    @foreach ($cat->categories as $sub)
                                        <li><a href="{{ route('category.primary', $sub->slug) }}">{{ $sub->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    {{-- /End of category --}}
    <style>
        ._hf8 {
            width: 50%;
            font-size: 18px;
            line-height: 1.42857;
        }

        ._BG2 {
            display: grid;
            grid: column;
            grid-column-gap: 30px;
            grid-template-columns: auto auto auto;
            grid-row-gap: 30px;
        }

        ._BG2_Card {
            width: 100%;
            flex: 0 0 auto;
            display: flex;
            position: relative;
            padding-top: 70%;
            border-radius: 18px;
            overflow: hidden;
        }

        ._d_title {
            margin: 10px 0 5px 0;
        }

        ._BG_img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        ._BG_Dwn {
            display: flex;
            align-items: center;
        }

        ._BG_svg {
            margin-right: 8px;
        }

        ._HM_a {
            color: var(--gray-very-dark) !important;
        }

        @media only screen and (max-width: 920px) {
            ._hf8 {
                width: 100%;
            }

            ._BG2 {
                grid-template-columns: auto auto;

            }
        }

        @media only screen and (max-width: 600px) {

            ._BG2 {
                grid-template-columns: auto;

            }
        }

    </style>
    <div class="home-content mb">
        <div class="container clearPadMobile">
            <div class="home-content-card">
                <div class="home-content-card-title _MBL-addPad">
                    <h2>Discover more at CubeHall</h2>
                    <p class="typography-body2">You do more than just buy products from CubeHall. Visit the links below to
                        discover more.</p>
                </div>
                <div class="home-content-card-grid scrollable">
                    <div class="home-content-box-by-category round_c_s">
                        <a class="_HM_a" href="{{ route('explore.parlors') }}">
                            <div class="_BG2_Card">
                                <img class="_BG_img"
                                    src="{{ asset('assets/statics/ec245-b97b1f-d3944-5904-953f.webp') }}" alt="logo">
                            </div>
                            <div>
                                <div>
                                    <h3 class="_d_title">Parlor</h3>
                                </div>
                                <div class="typography-body2">
                                    Interactive online activities.
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="home-content-box-by-category round_c_s">
                        <a class="_HM_a" href="{{ route('program.showoff') }}">
                            <div class="_BG2_Card">
                                <img class="_BG_img"
                                    src="{{ asset('assets/statics/rob-brink-cPJP5MY83U0-unsplash.jpg') }}" alt="logo">
                            </div>
                            <div>
                                <div>
                                    <h3 class="_d_title">Showoff your collection</h3>
                                </div>
                                <div class="typography-body2">
                                    Flex every product you own
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="home-content-box-by-category round_c_s">
                        <a class="_HM_a" href="{{ route('program.associate') }}">
                            <div class="_BG2_Card">
                                <img class="_BG_img"
                                    src="{{ asset('assets/statics/80082-d4098-bdb04-8007-87330.webp') }}" alt="logo">
                            </div>
                            <div>
                                <div>
                                    <h3 class="_d_title">Associates</h3>
                                </div>
                                <div class="typography-body2">
                                    Earn by Sharing
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Open Studio --}}
    @if (Auth::check())
        @if (!Auth::user()->can('isPage'))
            <div class="home-banner mb">
                <div class="container">
                    <div class="home-banner-content round_c_m">
                        <div class="home-banner-wrapper">
                            <img src="{{ asset('assets/statics/malcolm-lightbody-gPRvTP0sZ2M.jpg') }}" alt="">
                        </div>
                        <div class="home-banner-meta">
                            <div>
                                <h2 class="typography-headline2">Take your passion to next level</h2>
                                <p class="typography-body2">You deserve to make a living doing what you love.</p>
                            </div>
                            <div>
                                <a href="{{ route('OpenStudio') }}" class="btn-secondary btn-normalize">Open a Studio</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="home-banner mb">
            <div class="container">
                <div class="home-banner-content round_c_m">
                    <div class="home-banner-wrapper">
                        <img src="{{ asset('assets/statics/malcolm-lightbody-gPRvTP0sZ2M.jpg') }}" alt="">
                    </div>
                    <div class="home-banner-meta">
                        <div>
                            <h2 class="typography-headline2">Take your passion to next level</h2>
                            <p class="typography-body2">Everyone deserves to make a living doing what they love.</p>
                        </div>
                        <div>
                            <a href="{{ route('OpenStudio') }}" class="btn-secondary btn-normalize">Open a Studio</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    @endif
    {{-- /Open Studio --}}

    {{-- History --}}
    @if (count($RecentlyViewedProducts) > 0)
        <div class="mb">
            <div class="container clearPadMobile">
                <div class="recent-content">
                    <div class="_MBL-addPad">
                        <h4 class="typography-headline4 thead">Continue shopping</h4>
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
    {{--  --}}

    <div id="app" class="_MBL_fix_btm">
        <home-feed></home-feed>
    </div>
@endsection
