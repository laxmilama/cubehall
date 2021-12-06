@extends('layouts.shop')

@section('title')
    Brand
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
            grid-column-gap: 2%;
            grid-template-columns: 32.0% 32.0% 32.0%;
            grid-row-gap: 2%;
        }

        ._BG2_Card {
            width: 100%;
            flex: 0 0 auto;
            display: flex;
            position: relative;
            padding-top: 60%;
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

        ._BG_logo_guid {
            display: grid;
            grid: column;
            grid-column-gap: 2%;
            grid-template-columns: 49% 49%;
            grid-row-gap: 2%;
        }

        .BG_divided {
            display: grid;
            grid: column;
            grid-column-gap: 2%;
            grid-template-columns: 49% 49%;
            grid-row-gap: 2%;
        }

        .BG_d_IMG {
            width: 100%;
        }

        .BG_d_IMG img {
            width: 100%;
        }

        @media only screen and (max-width: 920px) {
            ._hf8 {
                width: 100%;
            }

            ._BG2 {
                grid-template-columns: auto auto;

            }

            ._BG_logo_guid {
                display: grid;
                grid: column;
                grid-column-gap: 2%;
                grid-template-columns: 100%;
                grid-row-gap: 2%;
            }
        }

        @media only screen and (max-width: 600px) {

            ._BG2 {
                grid-template-columns: auto;

            }
        }

        ._a__ {
            color: var(--gray-very-dark);
            text-decoration: underline;
        }

    </style>
    <div>
        <div class="container" style="display: flex; flex-direction:column">
            <div class="mt">
                <h1>Brand kit</h1>
                <div class="_hf8">All content downloaded from the Site (photography, audio, and video, etc.) may be
                    used for editorial purposes only. Any other use of Site content including, without limitation personal
                    or commercial use, is strictly prohibited.
                </div>
            </div>
            <div class="mt mb _BG2">
                <div>
                    <div class="_BG2_Card">
                        <img class="_BG_img" src="{{ asset('assets/statics/v1Brand@4x.png') }}" alt="logo">
                    </div>
                    <div>
                        <div>Brand assets</div>
                        <div>
                            <a class="_BG_Dwn" href="{{ asset('assets/statics/v1Brand@4x.png') }}" download>

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="_BG_svg">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="_BG2_Card">
                        <img class="_BG_img" src="{{ asset('assets/statics/mockv1.jpg') }}" alt="logo">
                    </div>
                    <div>
                        <div>Product screens</div>
                        <div>
                            <a class="_BG_Dwn" href="{{ asset('assets/statics/mockv1.jpg') }}" download>

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="_BG_svg">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="_BG2_Card">
                        <img class="_BG_img" src="{{ asset('assets/statics/v1Brand@4x.png') }}" alt="logo">
                    </div>
                    <div>
                        <div>Leadership photos</div>
                        <div>
                            <a class="_BG_Dwn" href="{{ asset('assets/statics/v1Brand@4x.png') }}" download>

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="_BG_svg">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt mb" style="display: flex; flex-direction: column;">
                <div style="text-align: center; display:flex; justify-content:center; flex-direction:column; align-items:center;">
                    <h1>Full guidelines</h1>
                    <div class="_hf8">
                        These CubeHall brand guidelines provide general rules about using our brand assets. We want to
                        ensure that both the CubeHall mark and logotype are always recognizable and legible.
                    </div>
                </div>
                <div class="_BG_logo_guid mt mb">
                    <div>
                        <div class="mb-m">
                            <h2>Logo Identity</h2>
                            <span class="_hf8">
                                Please respect our branding guidelines and do not alter the logo in any way.
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-s">

                            <div class="BG_divided">
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1primary_logo@2x.png') }}" alt="">
                                    <p>Our primary red logo.</p>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1secondary_logo@2x.png') }}" alt="">
                                    <p>You can also use a black and white approach.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_BG_logo_guid mt mb">
                    <div>
                        <h2>Logo use on Photos</h2>
                        <span class="_hf8">
                            The following are examples of logo usage on photographic backgrounds. Do not use
                            red-logo or
                            alter the color. Use the black version of the CubeHall logo on light photography and
                            white for darker photographs.
                        </span>
                    </div>
                    <div>
                        <div class="mt-s">
                            <div class="BG_divided">
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1background_white@2x.png') }}" alt="">
                                    <div>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1background_black@2x.png') }}" alt="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="_BG_logo_guid mt mb">
                    <div>
                        <div class="mb-m">
                            <h2>Things to avoid when using our logo</h2>
                            <span class="_hf8">
                                These examples illustrate unacceptable uses of our identity. Please respect our branding
                                guidelines and do not manipulate the CubeHall identity in any way.
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-s">

                            <div class="BG_divided">
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 20@2x.png') }}" alt="">
                                    <p>Do not add filters or effects to our logo.</p>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 21@2x.png') }}" alt="">
                                    <p>Do not outline the logo.</p>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 22@2x.png') }}" alt="">
                                    <p>Use red, white, or black logos with sufficient contrast for clear legibility.</p>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 23@2x.png') }}" alt="">
                                    <p>Do not stretch in any way.</p>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 24@2x.png') }}" alt="">
                                    <p>Do not use multiple colors for mark and logotype.</p>
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 25@2x.png') }}" alt="">
                                    <p>Do not rearrange the logo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_BG_logo_guid mt mb">
                    <div>
                        <div class="mb-m">
                            <h2>Call to action lockups</h2>
                            <span class="_hf8">
                                We provide templates for interactive call-to-action lockups to link your CubeHall studio
                                or person's profile. Or make your own, following the guides below.
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="mt-s">

                            <div class="BG_divided">
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 14@2x.png') }}" alt="">
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 15@2x.png') }}" alt="">
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 16@2x.png') }}" alt="">
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 18@2x.png') }}" alt="">
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 19@2x.png') }}" alt="">
                                </div>
                                <div class="BG_d_IMG">
                                    <img src="{{ asset('assets/statics/v1Asset 17@2x.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="_BG_logo_guid mt mb">
                    <div>
                        <div>
                            <div class="mt-s mb-m">
                                <h2>Press enquery</h2>
                            </div>
                            <div>
                                <strong>
                                    <a class="_a__" target="_blank"
                                        href="mailto:cubehall2@gmail.com">cubehall2@gmail.com</a>
                                </strong>
                                <p>
                                    Only members of the press will receive a response.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
