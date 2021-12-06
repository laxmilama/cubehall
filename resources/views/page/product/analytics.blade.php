@extends('layouts.adminLayout.admin_design')

@section('title')
    Analytics
@endsection
@section('content')
    <style>
        .p_an_img_wrap {
            width: 115px;
            padding-top: 145px;
            position: relative;
            flex-shrink: 0;
        }

        .p_an_img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;

        }

        .p_an_title {
            margin-left: 20px;
        }

        .p_an_data_chart {
            width: calc(calc(100% / 4) - 16px);
            position: relative;
            margin: 8px;
        }

        .p_an_details {
            display: grid;
            grid-template-columns: auto auto auto;
        }

        .p_an_d {
            display: flex;
            align-items: center;

        }

        .p_an_counter {
            margin-top: 15px;
            display: flex;
            align-items: center;
        }

        .p_an_value {
            padding: 5px;
            font-size: 18px;
        }

        .p_an_grid {
            display: flex;
            flex-wrap: wrap;
        }

        .p_an_link {
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        @media screen and (max-width: 600px) {
            .p_an_data_chart {
                width: calc(calc(100% / 2) - 16px);
                position: relative;
                margin: 8px;
            }
        }

    </style>
    <?php
    function truncateString($string, $limit)
    {
        if (strlen($string) > $limit) {
            return substr($string, 0, $limit) . '...';
        } else {
            return $string;
        }
    }
    ?>
    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="sm-container">
            <div id="app">
                <div class="ct12">
                    <div class="mt">
                        <h1 class="thead">Product Stats</h1>
                    </div>
                </div>
                <div class="row" style="display: inline-block;">
                    <div class="flex-box mt-m">
                        <div class="p_an_img_wrap round_c_s">

                            <img class="p_an_img"
                                src="{{ asset('images/product/small/' . $product->meta->thumbnail) }}">
                            <a class="p_an_link" href="{{ route('list', $product->slug) }}"></a>
                        </div>
                        <div class="p_an_title">
                            <h2>{{ $product->name }}</h2>
                            <p>{{ truncateString($product->description, 100) }}</p>
                            <span style="color:var(--gray-medium-dark)">Published on
                                {{ date('F d, Y', strtotime($product->created_at)) }}</span>
                        </div>
                    </div>
                    <div class="p_an_details mt mb">
                        <div>
                            <div class="p_an_d">
                                <span>Tags</span>
                                <tool-tip text="How many times people tagged your product">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-help-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </tool-tip>
                            </div>

                            <div class="p_an_counter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-tag">
                                    <path
                                        d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                                    </path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                                <strong class="p_an_value">{{ $tags }}</strong>
                            </div>
                        </div>
                        <div>
                            <span>Saves</span>
                            <tool-tip text="Saved your product">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-help-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </span>
                            </tool-tip>
                            <div class="p_an_counter">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-bookmark">
                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <strong class="p_an_value">{{ $saves }}</strong>
                            </div>
                        </div>
                        <div>
                            <span>Associates</span>
                            <tool-tip text="Number of people sharing your product">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-help-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </span>
                            </tool-tip>
                            <div class="p_an_counter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-link">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                                <strong class="p_an_value">{{ $associates }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <h3>Product performance over last 30 days</h3>
                    </div>
                    <div class="p_an_grid">
                        <div class="p_an_data_chart">
                            <product-mini-chart slug="{{ $product->slug }}" type="Impressions" :data="{{ $impressions }}">
                            </product-mini-chart>
                        </div>
                        <div class="p_an_data_chart">
                            <product-mini-chart slug="{{ $product->slug }}" type="Visits" :data="{{ $visits }}">
                            </product-mini-chart>
                        </div>
                        <div class="p_an_data_chart">
                            <product-mini-chart slug="{{ $product->slug }}" type="Orders" :data="{{ $orders }}">
                            </product-mini-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
