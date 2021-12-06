@extends('layouts.empty')

@section('title')
    Explore
@endsection

@section('content')
    <div>
        <style>
            ._404_head {
                margin: 0;
                margin-top: 60px;
            }

        </style>
        <div class="sm-container">
            <div style="display: inline-block">
                <h1 class="typography-headline1 _404_head">Error 500</h1>
                <h2>Internal server error</h2>
                <div>
                    Error code: 500
                </div>
                <div class="mt">
                    <strong>Here are some useful links.</strong>
                    <ul>
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="">Host a parlor</a></li>
                        <li><a href="{{route('program.associate')}}">Associate program</a></li>
                        <li><a href="{{route('OpenStudio')}}">Open a studio</a></li>
                        <li><a href="">Terms of service</a></li>
                        <li><a href="">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
