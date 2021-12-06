@extends('layouts.shop')

@section('title')
    Associate Profile - Site
@endsection

@section('content')
<div>
    <div class="container">
        <div style="display: inline-block; width:100%;">
            <div>
                <h1>Associate Profile</h1>
                <a title="Reply Message" href="mailto:{{$message->emai}}?subject=Re:{{$message->message}} &body=Hi, {{$message->name}} "><i class="fa fa-reply"></i></a>
            </div>

            <div id="app">
                <tabs-dyna>
                    <tab name="Assiciates">
                        <div class="___class_+?2___" data-init="copylink">
                            @if (count($associates) > 0)
    
                                <div class="ass">
                                    <div class="as-itm">Items</div>
                                    <div class="as-cnt">Seller</div>
                                    <div class="as-cnt">Views</div>
                                    <div class="as-cnt">Sales</div>
                                    <div class="as-cnt">Earnings</div>
                                </div>
                                @foreach ($associates as $link)
                                 @if($link->product !=null)
                             
                                    <div class="ass">
                                        <div class="flx as-itm">
                                            <div class="link_img_wrap round_c_s">
                                                <img class="as-thumb"
                                                    src="{{ asset('images/product/thumb/' . $link->product->meta->thumbnail) }}" alt="">
                                            </div>
                                            <div class="as-itm-dtl">
                                                <p class="as-title">{{ $link->product->name }}</p>
                                                <copy-link link="{{ $link->url }}"></copy-link>
                                            </div>
                                        </div>
                                        <div class="as-cnt flx vac">
                                            <a href="{{ route('studio', $link->owner->slug) }}">{{ $link->owner->name }}</a>
                                        </div>
                                        <div class="as-cnt flx vac">
                                            {{ $link->visits_count }}
                                        </div>
                                        <div class="as-cnt flx vac">
                                            {{ $link->sells_count }}
                                        </div>
                                        <div class="as-cnt flx vac">
                                            NPR. {{ $link->sells_amount }}
                                        </div>
                                    </div>
                                 @endif
                                @endforeach
            
            
                            @else
                                <div>
                                    <div class="_AS_head">
                                        <div>
                                            <h2>Promote any product
                                                and earn 5% or more</h2>
                                        </div>
                                        <div class="_AS_illustration _AS_influencer">
                                            <img src="{{ asset('assets/29-Influencer.svg') }}" alt="">
                                        </div>
                                        <div class="_AS_empty_info">
                                            <div>
                                                Make 5% or more of every sale when you recommend it using your
                                                associate link. You can copy and paste your link from
                                                any product page.
                                            </div>
            
                                            <div>
                                                Find out more about the <a href="">associate program</a>.
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            @endif
            
                        </div>
                    </tab>
                    <tab name="Finance">
                        <div>
                            <div>
                                <strong class="typography-headline2">{{Cookie::get('symbol')}}{{$total}}</strong>
                            </div>
                            <div>
                                <span>Current Balance</span>
                            </div>
                        </div>
                        <div>
                            <h2>Transactions</h2>
                            <div>
                                <table>
                                    <tr>
                                        <td>Amount</td>
                                        <td>Transaction Date</td>
                                    </tr>
                                    @foreach ($transactions as $t)
                                    <tr>
                                        <td>{{$t->currency}}{{$t->amount}}</td>
                                        <td>{{date_format($t->created_at,"Y-m-d, H:i")}}</td>
                                    </tr>                                        
                                    @endforeach
                                    
                                </table>
                            </div>
                        </div>
                    </tab>
                </tabs-dyna>

            </div>
        </div>

    </div>
</div>
    <div class="container">
        <div class="mt-s fix-cont mb-m">
            
        </div>
    </div>
@endsection
