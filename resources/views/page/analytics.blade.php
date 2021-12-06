@extends('layouts.adminLayout.admin_design')

@section('title')
    Analytics
@endsection
@section('content')

    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="container">
            <div id="app">
                <div>
                    <div class="mt mb-s">
                        <h1>Overview of your Studio</h1>
                    </div>
                    <div class="ct12 flx mb-m">
                        <div class="box-bound  content_border padding10px DB-stat">
                            <h2 class="typography-headline5">{{ $totalImpression }}</h2>
                            <strong class="typography-headline6">Impressions</strong>
                            <tool-tip text="Number of times your items seen on screen in last 30 days">
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
                            <h2 class="typography-headline5">{{ $totalViews }}</h2>
                            <strong class="typography-headline6">Total views</strong>
                            <tool-tip text="Total views in 30 days">
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
                            <h2 class="typography-headline5">{{ $uniqueVisitors }}</h2>
                            <strong class="typography-headline6">Unique Visitors</strong>
                            <tool-tip text="The number of unique visitors in last 30 days">
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
                            <h2 class="typography-headline5">{{ $orders }}</h2>
                            <strong class="typography-headline6">Orders</strong>
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
                            <h2 class="typography-headline5">{{ $conversionRate }}</h2>
                            <strong class="typography-headline6">Conv. Rate</strong>
                            <tool-tip text="Total visits converted into sells in last 30 days.">
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
                            <h2 class="typography-headline5">{{$followers}}</h2>
                            <strong class="typography-headline6">Followers</strong>
                            <tool-tip text="The number of followers in last 30 days">
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
                    <div class="ct12 mb-m">
                        <div class="box-bound  content_border  ct12">
                            <chart-impression></chart-impression>
                        </div>
                    </div>
					<div class="ct12">
						<div>
							<h2>Orders</h2>
						</div>
						<div class="box-bound  content_border  ct6 mt-s mb">
							<ordersby-date/>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
