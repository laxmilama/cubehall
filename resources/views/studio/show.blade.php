@extends('layouts.shop')

@section('title')
    {{ $studio->name }}
@endsection

@section('content')
    <style>
        :root {
            --brand: {{ $studio->brand_color }}
        }

    </style>
    <div id="app">
        <div class="store-banner">
            <div class="store-banner-wrapper">
                <img class="store-banner-pic" src="{{ asset('/images/cover/large/' . $studio->cover_image) }}" alt="">
            </div>
        </div>
        <div class="studio-details">
            <div class="container">
                <div class="studio-head">
                    <div class="studio-details-wrapper round_str">
                        <div class="info-flx">
                            <div class="flx" style="width: 100%; position: relative;">
                                <div class="studio-profile round_full">
                                    <img src="{{ asset('/images/profile/small/' . $studio->profile_image) }}" alt="">
                                </div>
                                <div class="studio-info">
                                    <div>
                                        <h1 class="no-marg studio_name txt-wt">{{ $studio->name }}</h1>
                                        <div>
                                            <h2 class="studio_handle">{{ '@' . $studio->slug }}</h2>
                                        </div>
                                        <div class="flx str-mt">

                                            <div class="store-reviews txt-wt">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="#888888" stroke="currentColor"
                                                    stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-star">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                                {{ $studio->studio_rating }} ( {{ $studio->reviews_count }} reviews)
                                            </div>
                                            <div class="store-reviews txt-wt">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="#888888" stroke="currentColor"
                                                    stroke-width="0" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-star">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                                {{ $studio->followers_count }} followers
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div data-init="follow">
                                {{-- {{dd($studio)}} --}}
                                <follow-studio :studio="{{ $studio }}"></follow-studio>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="scope">
                    {{-- {{dd($studio)}} --}}
                    <tabs studio="{{ $studio->slug }}">
                        @if ($studio->products_count > 0)
                            <tab name="Store" class="">
                                <div class="store-content  mt-m">
                                    <products :studio="{{ $studio }}" />
                                </div>
                            </tab>
                        @endif

                        @if ($studio->parlors_count > 0)
                            <tab name="Parlor">
                                <div class=" mt-m">
                                    <parlors :studio="{{ $studio }}" />
                                </div>
                            </tab>
                        @endif

                        @if ($studio->reviews_count > 0)
                            <tab name="Reviews">
                                <div class=" mt-m">
                                    <reviews :studio="{{ $studio }}" />
                                </div>
                            </tab>

                        @endif

                        <tab name="About">
                            <div class="mt-m">
                                <div class="flx studio_about">
                                    <div>
                                        <div>
                                            <div>
                                                <strong>Description</strong>
                                            </div>

                                            @if ($studio->meta_description)
                                                {{ $studio->meta_description }}
                                            @endif
                                        </div>

                                    </div>
                                    <div class="studio_about_st">
                                        <div>
                                            <strong>Details</strong>
                                        </div>
                                        
                                        Started from: {{ date('F d, Y', strtotime($studio->created_at)) }}
                                    </div>

                                </div>
                            </div>
                        </tab>



                    </tabs>

                </div>
            </div>
        </div>
    </div>
@endsection
