@extends('layouts.adminLayout.admin_design')

@section('title')
    Parlors
@endsection
@section('content')

    <style>
        ._AP_wrap {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        ._AP_card {
            width: 100%;
            display: flex;
        }

        ._AP_container {
            box-sizing: border-box;
            display: inline-block;
            margin-top: 12px;
            margin-bottom: 12px;
            overflow: visible;
            padding: 16px;
            position: relative;
            vertical-align: top;
            width: 100%;
        }

        ._AP_c36 {
            display: flex;
            width: 100%;
        }

        ._AP_cmg {
            width: 77px;
            height: 77px;
        }

        ._AP_img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        ._AP_box {
            background-color: var(--gray-very-light);
            border: 1px solid var(--gray-light);
            box-shadow: 0px 6px 16px rgb(0 0 0 / 12%) !important;
            border-radius: 4px;
            box-shadow: none;
        }

        ._AP_dtl {
            display: flex;
            flex: 1;
            min-width: 0;
            flex-direction: column;
            padding-left: 16px;

        }

        ._AP_dtl_1 {
            display: flex;
            flex: 0 0 auto;
            flex-direction: row;
            height: 32px;
            justify-content: space-between;
        }

        .flex-box {
            display: flex;
        }

        ._AL_title {
            margin-top: 32px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
        }

    </style>

    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="sm-container">
            <div class="">
                <div class="row">
                    <div class="_AL_title">
                        <h1>Parlors</h1>
                        <a href="{{route('createParlor')}}" class="btn-primary btn-normalize">Create new idea</a>

                    </div>

                    <div class="_AP_wrap">
                        @foreach ($parlors as $parlor)
                            <div class="_AP_card">
                                <div class="_AP_card _AP_container _AP_box">
                                    <span>
                                        <div class="_AP_card">
                                            <div class="_AP_c36">
                                                <div class="_AP_cmg round_c_s">
                                                    <img class="_AP_img"
                                                        src="{{ asset('images/parlor/thumb/' . $parlor->cover) }}">
                                                </div>
                                                <div class="_AP_dtl">
                                                    <div class="_AP_dtl_1">
                                                        <div class="flex-box">
                                                            <div>
                                                                <a href="{{ route('studio.parlors.show', $parlor->slug) }}">
                                                                    {{ $parlor->title }}
                                                                </a>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="flex-box">
                                                        <div>
                                                            Published:  July 10
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </span>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
