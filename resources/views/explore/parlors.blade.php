@extends('layouts.shop')

@section('title')
    Parlors
@endsection

@section('content')
    <div>
        <div class="container clearPadMobile" id="app">
            <div class="flex-box">
                <parlor-explore-section></parlor-explore-section>
            </div>
            @if (count($histories) > 0)
                <div class="mt-m">
                    <div class="_MBL-addPad">
                        <h2>Continue Browsing</h2>
                    </div>
                    <div class="parlor-more-wrapper scrollable _MBL-addPad">
                        @if ($histories != null)

                            @foreach ($histories as $item)
                                <parlor-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                                    local="{{ Cookie::get('currency') }}"
                                    currency="{{ $item->parlor->ticket->currency }}" title="{{ $item->parlor->title }}"
                                    thumbnail="{{ $item->parlor->cover }}" slug="{{ $item->parlor->slug }}"
                                    amount="{{ $item->parlor->ticket->price }}"
                                    star_count="{{ $item->parlor->star_count }}"
                                    reviews_count="{{ $item->parlor->reviews_count }}"
                                    location="{{ $item->parlor->location }}"
                                    available="{{ $item->parlor->ticket->is_available }}" parlor="{{ $item->id }}"
                                    parent="{{ $item->owner->id }}" type="{{ $item->type }}">
                                </parlor-card>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            {{-- Best Sellers --}}
            @if ($bests != null)
                <div class="mb mt">
                    <div>
                        <div class="_MBL-addPad">
                            <h2>Best Sellers</h2>
                        </div>
                        <div class="parlor-more-wrapper scrollable _MBL-addPad">
                            @foreach ($bests as $item)
                                <parlor-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                                    local="{{ Cookie::get('currency') }}" currency="{{ $item->ticket->currency }}"
                                    title="{{ $item->title }}" thumbnail="{{ $item->cover }}"
                                    slug="{{ $item->slug }}" amount="{{ $item->ticket->price }}"
                                    star_count="{{ $item->star_count }}" reviews_count="{{ $item->reviews_count }}"
                                    location="{{ $item->location }}" available="{{ $item->ticket->is_available }}"
                                    parlor="{{ $item->id }}" parent="{{ $item->owner->id }}"
                                    type="{{ $item->type }}"
                                    >
                                </parlor-card>
                            @endforeach

                        </div>

                    </div>
                </div>
            @endif
            {{-- /Best Sellers --}}


            @if (count($now) != 0)
                <div class="mt mb">
                    <div>
                        <div class="_MBL-addPad">
                            <h2>Starting in next 8 hours</h2>
                        </div>
                        <div class="parlor-more-wrapper scrollable _MBL-addPad">
                            @foreach ($now as $parlor)
                                <parlor-now rates="{{ $c }}" parlor="{{ $parlor }}"
                                    symbol="{{ Cookie::get('symbol') }}" currency="{{ Cookie::get('currency') }}">
                                </parlor-now>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


            @if ($news != null)
                <div class="mt mb">
                    <div>
                        <div class="_MBL-addPad">
                            <h2>New this month</h2>
                        </div>
                        <div class="parlor-more-wrapper scrollable _MBL-addPad">
                            @foreach ($news as $item)
                                <parlor-card rates="{{ $c }}" symbol="{{ Cookie::get('symbol') }}"
                                    local="{{ Cookie::get('currency') }}" currency="{{ $item->ticket->currency }}"
                                    title="{{ $item->title }}" thumbnail="{{ $item->cover }}"
                                    slug="{{ $item->slug }}" amount="{{ $item->ticket->price }}"
                                    star_count="{{ $item->star_count }}" reviews_count="{{ $item->reviews_count }}"
                                    location="{{ $item->location }}" available="{{ $item->ticket->is_available }}"
                                    parlor="{{ $item->id }}" parent="{{ $item->owner->id }}"
                                    type="{{ $item->type }}">
                                </parlor-card>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif


            <div class="mt mb">
                <div class="_MBL-addPad">
                    <h2>All {{ env('APP_NAME') }} parlors</h2>
                </div>
                <div class="_MBL-addPad">
                    <all-parlor currency="{{ Cookie::get('currency') }}" symbol="{{ Cookie::get('symbol') }}">
                    </all-parlor>
                </div>
            </div>

        </div>
    </div>
@endsection
