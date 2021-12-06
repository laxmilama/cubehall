@extends('layouts.shop')

@section('title')
    Yeden Sherpa
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

        ._lead_ {
            display: flex;
        }

        ._name {
            margin-bottom: 5px;
        }

        ._brief {
            padding-right: 60px;
        }

        @media only screen and (max-width: 920px) {
            ._hf8 {
                width: 100%;
            }

            ._BG2 {
                grid-template-columns: auto auto;

            }

            ._lead_ {
                display: flex;
                flex-direction: column-reverse;
            }
        }

        @media only screen and (max-width: 600px) {

            ._BG2 {
                grid-template-columns: auto;

            }
        }

        .bio {
            font-size: 16px;
            line-height: 24px;
        }

    </style>
    <div>
        <div class="container" style="display: flex; flex-direction:column">
            <div class="mt mb-m">

                <div class="_lead_">
                    <div class="_brief" style="width: 100%">
                        <h1 class="typography-headline2 _name">Yeden Sherpa</h1>
                        <strong>Co-founder and Chief Executive Officer</strong>
                        <div class="mt-m bio">
                            <p>
                                Yeden Sherpa is the co-founder and Chief Executive Officer of CubeHall and takes
                                responsibility for the vision and strategy of the company.
                            </p>
                            <p>
                                A fine art graduate from the Kathmandu University, School of Arts and Design, Yeden has
                                planted his creative root in every aspect of Cubehall's process, product, and culture.
                            </p>
                        </div>
                    </div>
                    <div style="width: 100%">
                        <div class="_BGF_Card">
                            <img class="_BG_img" src="{{ asset('assets/statics/yeden.jpg') }}" alt="logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
