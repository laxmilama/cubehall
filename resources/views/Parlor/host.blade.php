@extends('layouts.helper')

@section('title')
    Host parlor
@endsection

@section('content')

    <div>
        <div class="container">
            <div class="mt">
                <a href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="studio_logo"
                        viewBox="0 0 20.36 20.34">
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="Layer_1-2" data-name="Layer 1">
                                <path
                                    d="M9.4,20.34H1.79A1.79,1.79,0,0,1,0,18.55v-7.7A2.65,2.65,0,0,1,2.65,8.2H4.12a2.73,2.73,0,0,1,2.73,2.73V13a.5.5,0,0,0,.5.49h2a2.74,2.74,0,0,1,2.74,2.74v1.39A2.72,2.72,0,0,1,9.4,20.34ZM2.65,9.49A1.36,1.36,0,0,0,1.3,10.85v7.7a.5.5,0,0,0,.49.5H9.4a1.43,1.43,0,0,0,1.43-1.43V16.23a1.44,1.44,0,0,0-1.44-1.44h-2A1.79,1.79,0,0,1,5.56,13V10.93A1.45,1.45,0,0,0,4.12,9.49Z" />
                                <path
                                    d="M15.09,20.34a1.66,1.66,0,0,1-.61-.12,1.59,1.59,0,0,1-1-1.47V7.14a.29.29,0,0,0-.29-.29H1.61A1.58,1.58,0,0,1,.49,4.14L4.17.46A1.62,1.62,0,0,1,5.29,0H18.77a1.59,1.59,0,0,1,1.59,1.59V15.08a1.6,1.6,0,0,1-.47,1.12l-3.68,3.68A1.59,1.59,0,0,1,15.09,20.34Zm-9.8-19a.32.32,0,0,0-.21.08L1.41,5.06a.3.3,0,0,0-.07.32.29.29,0,0,0,.27.18h11.6A1.59,1.59,0,0,1,14.8,7.14V18.75A.28.28,0,0,0,15,19a.26.26,0,0,0,.31-.06L19,15.28a.3.3,0,0,0,.08-.2V1.59a.29.29,0,0,0-.29-.29Z" />
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <div class="sm-container">
            <div class="mFix">
                <div class="mb _HostPlr_head">
                    <h1 class="_HostPlr_head_1">Earn money doing activities you love.</h1>
                    <span class="_AS_content _HostPlr_head_p">Yes, {{ env('APP_NAME') }} makes it possible and easy for
                        you.</span>
                    <div>
                        <a href="" class="mt-m btn-normalize bag-btn bag _HostPlr_btn"> Get started</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <img width="100%" src="{{ asset('assets/statics/parlor_hosts.png') }}" alt="">
        </div>
        <div class="sm-container">
            <div class="mfix">
                <div class="_HostPlr-mt">
                    <div>
                        <h2 class="typography-headline3 _AS_head-t1">What's a parlor?</h2>
                        <p class="_AS_content">
                            It’s an online activity produced and managed by creators. Parlor can be anything like
                            show off
                            your skills, crafting, cooking, yoga, culture, and more. There’s no limit to what you
                            can do; build community with people who share your passions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt">
            <div class="sm-container">
                <div class="mfix">
                    <div class="_HostPlr-mt">
                        <div class="_AS_head">
                            <div>
                                <h1 class="typography-headline3 _AS_head-t1">How does it work?</h1>
                            </div>
                            <div class="_AS_content mt-m mb">
                                You will be qualified to create a parlor from your studio in 3 simple steps.
                            </div>

                        </div>
                    </div>
                    <div class="mt-s mb" style="display: inline-block; width:100%;">
                        <div class="_AS_basic_wrap ">
                            <div class="_AS_basic_card">
                                <div class="_AS_basic_card_ico">
                                    <div class="_AS_basic_card_i">
                                        1
                                    </div>
                                    <div class="_AS_basic_title">
                                        <h2>Design an activity your way.</h2>
                                    </div>
                                    <div>
                                        <div class="_AS_h5">
                                            Meet our quality standards then you will get access to the studio to create and
                                            manage a parlor. We are looking for expertise and engaging participation. If you
                                            have an idea start the submission.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_AS_basic_card">
                                <div class="_AS_basic_card_ico">
                                    <div class="_AS_basic_card_i">
                                        2
                                    </div>
                                    <div class="_AS_basic_title">
                                        <h2>Submit for review</h2>
                                    </div>
                                    <div>
                                        <div class="_AS_h5">
                                            You are ready to submit for review when you complete describing what you are
                                            offering in detail. Our team will read it over and let you know if it's been
                                            approved within 1-14 days.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="_AS_basic_card">
                                <div class="_AS_basic_card_ico">
                                    <div class="_AS_basic_card_i">
                                        3
                                    </div>
                                    <div class="_AS_basic_title">
                                        <h2>Prepare and host a parlor</h2>
                                    </div>
                                    <div>
                                        <div class="_AS_h5">
                                            While you wait, start planning for your camera set-up, lighting, and location.
                                            If your parlor meets our standards, you’re ready to schedule dates for tickets
                                            and start earning.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sm-container ">
            <div class="mfix">
                <div class="mt mb">
                    <h1 class="typography-headline3 _AS_head-t1">Calling all creators.</h1>
                    <span class="_AS_content mt-s">Creative individuals is the future brand. It's economy is just getting
                        started.</span>

                    <div>
                        <a href="" class="mt-m btn-normalize bag-btn bag _HostPlr_btn"> Get started</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
