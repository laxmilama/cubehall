@extends('layouts.shop')

@section('title')
    About
@endsection

@section('content')
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

        ._BGF_Card {
            width: 100%;
            flex: 0 0 auto;
            display: flex;
            position: relative;
            padding-top: 100%;
            border-radius: 18px;
            overflow: hidden;
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

        ._B_name {
            color: var(--gray-very-dark);
            margin-bottom: 5px;
        }

        ._B_name:hover {
            text-decoration: underline;
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
    <div>
        <div class="banner">
            <div class="banner-wrapper">
                <div class="banner-centered">
                    <img class="banner-pic"
                        src="{{ asset('assets/statics/pascal-bernardon-2514jivSHqQ-unsplash.jpg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="container mt">
            <div class="mt mb">
                <h2 class="typography-headline1">Shop original from independent creators and brands.</h2>
            </div>

        </div>
        <div class="container" style="display: flex; flex-direction:column">
            <div class="mt mb-m">
                <h1>About Us</h1>
                <div class="_hf8">The idea for CubeHall was sailed back in 2018 when Yeden could not sell his
                    creative products in Nepal. In 2021, Laxmi Tamang agreed to bring it to life and that idea starts to
                    take tangible form. Since then, we are relentlessly working with the vision for a better place to
                    create, buy and sell.
                </div>
            </div>
            <div class="mt">
                <h1>Founders</h1>
            </div>
            <div class="mb _BG2">
                <div>
                    <div class="_BGF_Card">
                        <a href="{{ route('leadership.yeden') }}">
                            <img class="_BG_img" src="{{ asset('assets/statics/yeden.jpg') }}" alt="logo">
                        </a>
                    </div>
                    <div>
                        <div style="margin-top:15px;"><a href="{{ route('leadership.yeden') }}">
                                <h3 class="_B_name">P. Yeden Sherpa</h3>
                            </a></div>
                        <div>
                            <span>Co-founder and Chief Executive Officer</span>
                        </div>

                    </div>
                </div>
                <div>
                    <div class="_BGF_Card">
                        <a href="{{ route('leadership.laxmi') }}">
                            <img class="_BG_img" src="{{ asset('assets/statics/laxmi.jpg') }}" alt="logo">
                        </a>
                    </div>
                    <div>
                        <div style="margin-top:15px;"><a href="{{ route('leadership.laxmi') }}">
                                <h3 class="_B_name">Laxmi Tamang</h3>
                            </a></div>
                        <div>
                            <span>Co-founder and Chief Operating Officer</span>
                        </div>

                    </div>
                </div>
                <div>
                    <div class="_BGF_Card">
                        <a href="{{ route('brand') }}">
                            <img class="_BG_img" src="{{ asset('assets/statics/v1Brand@4x.png') }}" alt="logo">
                        </a>
                    </div>
                    <div>
                        <div style="margin-top:15px;"><a href="{{ route('brand') }}">
                                <h3 class="_B_name">Brand Kit</h3>
                            </a></div>
                        <div>
                            <span>Brand kit, Screenshots, Videos and more</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
