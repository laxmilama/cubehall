@extends('layouts.adminLayout.admin_design')

@section('title')
    Analytics
@endsection
@section('content')

    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="container">
            <div id="app">
                <div>
                    <div class="mt mb-m">
                        <h2>Finance Summery</h2>
                    </div>
                    <div class="mb-m">
                        <monthly-product-chart symbol="{{ $symbol }}" data="{{ $analytics }}"
                            data1="{{ $parloranalytics }}" />
                    </div>
                    <div class="_FNC mt">

                        <div class="_FNC-card">
                            <h2>Overal sells</h2>
                            <p>Total sels made over the time period.</p>
                            @if ($finance)
                                <div>
                                    <span>Gross Profit</span> {{ $finance->total }}
                                </div>
                                <div>
                                    <span>Associate</span> {{ ($finance->total / 100) * 15 }}
                                </div>
                                <div>
                                    <span>Shipping</span> {{ $finance->delivery }}
                                </div>
                                <div>
                                    <span>Total Sells</span> {{ $finance->total - ($finance->total / 100) * 15 }}
                                </div>
                            @else
                                <div>
                                    <span>Gross Profit</span> 0
                                </div>
                                <div>
                                    <span>Associate</span> 0
                                </div>
                                <div>
                                    <span>Shipping</span> {0
                                </div>
                                <div>
                                    <span>Total Sells</span>0
                                </div>

                            @endif
                        </div>
                        <div class="_FNC-card">
                            <div>
                                <h2>Total sells in last 30 days</h2>
                                <p>
                                    Report generated only using successfull delivered sells.
                                </p>
                            </div>
                            <div>
                                <span>Gross Profit</span>{{ $symbol }}{{ $product }}
                            </div>
                            <div>
                                <span>Associate</span> {{ $symbol }}{{ $associate }}
                            </div>
                            <div>
                                <span>Shipping</span> {{ $symbol }}{{ $shipping }}
                            </div>
                            <div>
                                <span>Total Sells</span>{{ $symbol }}{{ $product - $associate }}
                            </div>
                        </div>
                        <div class="_FNC-card">
                            <div>
                                <h3>Unpaid</h3>
                                <p>Schedulled for upcoming payment.</p>
                                <span>Payment</span> {{ $symbol }}{{ $due }}
                            </div>
                        </div>
                    </div>
                    <div class="_FNC">
                        <div class="_FNC-card">
                            <h2>Parlor Earning</h2>
                            <p>Total parlor earning onver 30 days period.</p>
                            <div>
                                <span>Paid</span> {{ $symbol }}{{ $parlorpaid }}
                            </div>
                            <div>
                                <span>Unpaid</span> {{ $symbol }}{{ $parlor }}
                            </div>
                        </div>
                        <div class="_FNC-card">
                            <h2>Total Remaining Due Payment</h2>
                            <p>This is overal payment remaining</p>
                            <div>
                                <span>Unpaid</span> {{ $symbol }}{{ $parlor + $due }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
