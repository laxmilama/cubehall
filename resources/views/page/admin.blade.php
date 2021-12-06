@extends('layouts.adminLayout.admin_design')

@section('title')
    Studio Dashboard
@endsection
@section('content')

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script> --}}

    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="container">
            <div class="">
                <div class=" row">
                    <div class="box-bound margin10px padding10px ct12 space_betwwen">
                        <div>
                            <h2>Studio Dashboard</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="padding10px">
                        <div data-init="story">
                            <add-story userid="{{ Auth::user()->id }}" pageid="{{ Auth::user()->pages->first()->id }}"
                                :viewer="{{ Auth::user() }}"></add-story>

                        </div>
                    </div>
                    <div class="ct12 flx" id="app">
                        <div class="box-bound  content_border padding10px DB-stat">
                            <label class="statLbl">58%</label>
                            <h2 class="typography-headline5">19.4k</h2>
                            <strong class="typography-headline6">Followers</strong>
                            <tool-tip text="The number of items sold in last 30 days">
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
                        </div>
                        <div class="box-bound  content_border padding10px DB-stat">
                            <label class="statLbl">100%</label>
                            <h2 class="typography-headline5">20</h2>
                            <strong class="typography-headline6">Products</strong>
                            <tool-tip text="Total income generated from the sells in 30 days">
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
                        </div>
                        <div class="box-bound  content_border padding10px DB-stat">
                            <label class="statLbl">200%</label>
                            <h2 class="typography-headline5">4000</h2>
                            <strong class="typography-headline6">Parlors</strong>
                            <tool-tip text="The number of items sold in last 30 days">
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
                        </div>
                        <div class="box-bound  content_border padding10px DB-stat">
                            <label class="statLbl">58%</label>
                            <h2 class="typography-headline5">5k</h2>
                            <strong class="typography-headline6">Reviews</strong>
                            <tool-tip text="The number of items sold in last 30 days">
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
                        </div>
                    </div>
                </div>
                <div class="row" data-init="d-chart">
                    <div class="box-bound  content_border  ct12">
                        <planet-chart></planet-chart>
                    </div>

                </div>
                <style>
                    ._Odr0d{
                        margin-top: 8px;
                        margin-bottom: 6px;
                    }
                    ._Odr0d_img{
                        height: 60px;
                        width: 60px;                        
                    }
                    ._Odr0d_plr{
                        height: 70px;
                        width:70px;
                        overflow: hidden;
                        margin-right: 15px;
                    }
                    ._Odr0d_plr img{
                        height: 100%;
                        width: 100%;
                        object-fit: cover;
                    }
                </style>
                <div class="row">
                    <div  class="flex-box mb">
                        <div class="mt" style="width:100%">
                            <div>
                                <h2>New Orders</h2>
                            </div>
                            <div>
                                @foreach ($orders as $order)
                                    <div class="flex-box _Odr0d">
                                        <div>
                                            <a href="{{ route('orderDetails', $order->id) }}">
                                                <img class="_Odr0d_img" src="{{ asset('images/product/thumb/' . $order->thumbnail) }}" alt="">
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('orderDetails', $order->id) }}">
                                                <div>
                                                    <strong>
                                                        {{ $order->product_name }}
                                                    </strong>
                                                </div>
                                                <div>
                                                    Quantity: {{ $order->quantity }}
                                                </div>
                                                <div>
                                                    {{ $order->created_at }}
                                                </div>

                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt" style="width:100%">
                            <div>
                                <h2>Upcoming Parlor</h2>
                            </div>
                            <div>
                                @foreach ($tickets as $parlor)
                                    <div class="flex-box mt-s">
                                        <div class="_Odr0d_plr round_c_s">
                                            <img src="{{asset('images/parlor/thumb/'. $parlor->cover)}}" alt="">
                                        </div>                                        
                                        <div>
                                            <strong>{{$parlor->title}}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
