@extends('layouts.adminLayout.admin_design')
@section('content')
    <div class="admin_content_wrapper">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="justify_center">
            <div id="AdmCont" class="fullwidth padlft">
                <style>
                    ._AL_wrap {
                        width: 100%;
                        display: flex;
                        flex-direction: column;
                    }

                    ._AL_card {
                        width: 100%;
                        display: flex;
                    }

                    ._AL_box {
                        background-color: var(--gray-very-light);
                        border: 1px solid var(--gray-light);
                        box-shadow: 0px 6px 16px rgb(0 0 0 / 12%) !important;
                        border-radius: 4px;
                        box-shadow: none;
                    }

                    ._AL_container {
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

                    .flex-box {
                        display: flex;
                    }

                    ._AL_c36 {
                        display: flex;
                        width: 100%;
                    }

                    ._AL_cmg {
                        width: 77px;
                        height: 77px;
                    }

                    ._AL_img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    ._AL_title {
                        margin-top: 32px;
                        margin-bottom: 24px;
                    }

                </style>
                <div class="sm-container">
                    <div class="_AL_wrap mt-m">                
                        <div id="app">
                            <studio-product-list :products="{{$products}}" :studioid="{{Auth::user()->pages->first()->id}}"></studio-product-list>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
