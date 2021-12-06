@extends('layouts.helper')
@section('title')
    Online Studio
@endsection
@section('content')
    <div id="app">
        @if (!Auth::user()->can('isPage'))
            @if (Auth::user()->kyc == 'unverified')
                <div>
                    <div class="sm-container">
                        <div class="mt">
                            <h1 class="typography-headline2 _AS_head-t1">
                                Verify your identity
                            </h1>
                            <p class="_AS_content">We aim to build a safe, secure, and trusted business. That is why we’ll
                                need you to add an
                                official government ID. This step helps to prevent fraud, streamline risk operations, and
                                increase trust and safety.</p>
                              
                            <p class="_AS_content">Please <a href="{{ route('account.kyc') }}" class="link">
                                    Verify your government ID</a> to create studio and do business with us.</p>
                            <p class="_AS_content">It usually takes 1-7 days.</p>
                        </div>
                    </div>
                </div>
            @else
                <studio-create></studio-create>
            @endif
        @else

            <div class="">
                <div class=" sm-container">
                    <div>
                        <a href="">

                        </a>
                    </div>
                    <h1>You already own a studio</h1>
                    <article>Currently we only support single studio per user.</article>
                </div>
            </div>

        @endif
    @endsection
