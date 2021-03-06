@extends('layouts.shop')

@section('title')
    Account Settings
@endsection

@section('content')
    <style>
        ._setting_grid {
            display: grid;
            grid-template-columns: 32% 32% 32%;
            grid-gap: 2%;
            column-gap: 2%;
            row-gap: 4%;
        }

        ._setting_box {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            border: solid 1px var(--gray-light);
            border-radius: 8px;
        }

        ._setting_box a {
            width: 100%;
            display: block;
        }

        ._setting_head {
            margin: 10px 0;
        }
        @media only screen and (max-width: 600px) {
            ._setting_grid {
            display: grid;
            grid-template-columns: 49% 49%;
            grid-gap: 2%;
        }
        }

    </style>
    <div class="small_container">
        <div class="mt-s fix-cont mb-m">
            <div>
                <h1>Account Settings</h1>
            </div>
            <div class="_setting_grid">
                <div class="_setting_box">
                    <a href="{{ route('account.personal') }}">
                        <div>
                            <svg version="1.1" id="Layer_1" width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                xml:space="preserve">
                                <path
                                    d="M458.667,341.333h-85.333c-5.888,0-10.667,4.779-10.667,10.667c0,5.888,4.779,10.667,10.667,10.667h85.333
                                            c5.888,0,10.667-4.779,10.667-10.667C469.333,346.112,464.555,341.333,458.667,341.333z">
                                </path>
                                <path d="M309.333,234.667h64c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667h-64
                                            c-5.888,0-10.667,4.779-10.667,10.667S303.445,234.667,309.333,234.667z"></path>
                                <path d="M416,234.667h42.667c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H416
                                            c-5.888,0-10.667,4.779-10.667,10.667S410.112,234.667,416,234.667z"></path>
                                <path d="M309.333,298.667h149.333c5.888,0,10.667-4.779,10.667-10.667s-4.779-10.667-10.667-10.667H309.333
                                            c-5.888,0-10.667,4.779-10.667,10.667S303.445,298.667,309.333,298.667z"></path>
                                <path
                                    d="M309.333,362.667h21.333c5.888,0,10.667-4.779,10.667-10.667c0-5.888-4.779-10.667-10.667-10.667h-21.333
                                            c-5.888,0-10.667,4.779-10.667,10.667C298.667,357.888,303.445,362.667,309.333,362.667z">
                                </path>
                                <path d="M458.667,64H53.333C23.936,64,0,87.936,0,117.333v277.333C0,424.064,23.936,448,53.333,448h405.333
                                            C488.064,448,512,424.064,512,394.667V117.333C512,87.936,488.064,64,458.667,64z M490.667,394.667c0,17.643-14.357,32-32,32
                                            H53.333c-17.643,0-32-14.357-32-32V149.333h469.333V394.667z M490.667,128H21.333v-10.667c0-17.643,14.357-32,32-32h405.333
                                            c17.643,0,32,14.357,32,32V128z"></path>
                                <path
                                    d="m158,320.6c-52.1,0-93.8,42.7-93.8,93.8h20.8c0-40.7 32.3-73 73-73s73,32.3 73,73h20.9c-0.1-51-41.8-93.8-93.9-93.8z">
                                </path>
                                <path
                                    d="m159,307.1c25,0 45.9-20.9 46.9-46.9 0-26.1-20.9-46.9-46.9-46.9s-46.9,20.9-46.9,46.9c0,26 20.9,46.9 46.9,46.9zm0-73c14.6,0 26.1,11.5 26.1,26.1s-11.5,26.1-26.1,26.1c-14.6,0-26.1-11.5-26.1-26.1s11.5-26.1 26.1-26.1z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="_setting_head">Personal Info</h3>
                        <span>Personal and public information.</span>
                    </a>
                </div>
                <div class="_setting_box">
                    <a href="{{ route('account.security') }}">
                        <div>
                            <svg version="1.1" id="Layer_1" width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 290.626 290.626"
                                style="enable-background:new 0 0 290.626 290.626;" xml:space="preserve">

                                <path style="fill:#F9BA48;" d="M234.375,150h-15l-3.75,9.375h-4.688l-3.75-9.375H191.25l-3.75,9.375h-4.688l-3.75-9.375h-15.938
               l-3.75,9.375h-4.687l-3.75-9.375H126.81c-6.909-13.88-21.197-23.438-37.748-23.438c-23.302,0-42.187,18.886-42.187,42.188
               s18.886,42.188,42.187,42.188c16.556,0,30.844-9.558,37.748-23.438h107.564l14.063-18.75L234.375,150z" />
                                <path style="fill:#333333;" d="M290.625,56.25c0-31.017-25.233-56.25-56.25-56.25H56.25C25.233,0,0,25.233,0,56.25
               c0,18.816,9.319,35.461,23.55,45.68c-0.038,0.398-0.112,0.797-0.112,1.195V243.75c0,7.753,6.309,14.063,14.062,14.063h46.875
               v23.438H60.938v9.375h23.437H206.25h23.437v-9.375H206.25v-23.438h46.875c7.753,0,14.063-6.309,14.063-14.063V103.125
               c0-0.398-0.075-0.797-0.113-1.195C281.306,91.711,290.625,75.066,290.625,56.25z M196.875,281.25H93.75v-23.438h103.125V281.25z
               M253.125,248.438H206.25H84.375H37.5c-2.588,0-4.688-2.105-4.688-4.688v-9.375h225v9.375
               C257.813,246.333,255.712,248.438,253.125,248.438z M257.813,225h-225V107.32c7.144,3.291,15.066,5.18,23.437,5.18h178.125
               c8.372,0,16.294-1.889,23.438-5.18V225z M234.375,103.125H56.25c-25.847,0-46.875-21.028-46.875-46.875S30.403,9.375,56.25,9.375
               h178.125c25.847,0,46.875,21.028,46.875,46.875S260.222,103.125,234.375,103.125z" />
                                <path style="fill:#333333;" d="M103.125,42.188c0-15.511-12.614-28.125-28.125-28.125S46.875,26.677,46.875,42.188v4.688h-4.687
               v51.563h65.625V46.875h-4.688V42.188z M56.25,42.188c0-10.341,8.409-18.75,18.75-18.75s18.75,8.409,18.75,18.75v4.688h-37.5
               V42.188z M98.438,89.063H51.563V56.25h46.875V89.063z" />
                                <path style="fill:#333333;" d="M70.313,78.384v5.991h9.375v-5.991c2.789-1.627,4.688-4.617,4.688-8.072
               c0-5.17-4.205-9.375-9.375-9.375s-9.375,4.205-9.375,9.375C65.625,73.767,67.523,76.758,70.313,78.384z" />
                                <polygon style="fill:#333333;" points="157.012,44.892 145.313,48.694 145.313,37.5 135.938,37.5 135.938,48.694 124.238,44.892 
               121.345,53.808 133.041,57.609 125.813,67.556 133.392,73.069 140.625,63.117 147.858,73.069 155.438,67.556 148.209,57.609 
               159.905,53.808 		" />
                                <polygon style="fill:#333333;" points="203.887,44.892 192.187,48.694 192.187,37.5 182.812,37.5 182.812,48.694 171.112,44.892 
               168.22,53.808 179.916,57.609 172.687,67.556 180.267,73.069 187.5,63.117 194.733,73.069 202.312,67.556 195.084,57.609 
               206.78,53.808 		" />
                                <polygon style="fill:#333333;" points="250.762,44.892 239.062,48.694 239.062,37.5 229.687,37.5 229.687,48.694 217.987,44.892 
               215.095,53.808 226.791,57.609 219.562,67.556 227.142,73.069 234.375,63.117 241.608,73.069 249.187,67.556 241.959,57.609 
               253.655,53.808 		" />
                                <path style="fill:#333333;" d="M70.313,154.688c-7.753,0-14.062,6.309-14.062,14.063s6.309,14.063,14.062,14.063
               s14.062-6.309,14.062-14.063S78.066,154.688,70.313,154.688z M70.313,173.438c-2.588,0-4.688-2.105-4.688-4.688
               s2.1-4.688,4.688-4.688S75,166.167,75,168.75S72.9,173.438,70.313,173.438z" />
                            </svg>

                        </div>

                        <h3 class="_setting_head">Password & Security</h3>
                        <span>Update your password to secure your account.</span>
                    </a>
                </div>
                <div class="_setting_box">
                    <a href="{{ route('account.payment') }}">
                        <div>

                            <?xml version="1.0" encoding="iso-8859-1"?>
                            <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                            <svg version="1.1" id="Layer_1" width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512;" xml:space="preserve">

                                <path d="M97.28,269.454v38.533H76.268c-7.068,0-12.8,5.731-12.8,12.8c0,7.069,5.732,12.8,12.8,12.8H97.28v9.494
        c0,7.069,5.732,12.8,12.8,12.8c7.068,0,12.8-5.731,12.8-12.8v-10.46c24.818-3.843,41.244-18.936,41.244-39.329v-8.174
        c0-20.393-16.426-35.488-41.244-39.331v-38.533h21.012c7.068,0,12.8-5.731,12.8-12.8c0-7.069-5.732-12.8-12.8-12.8H122.88v-9.494
        c0-7.069-5.732-12.8-12.8-12.8c-7.068,0-12.8,5.731-12.8,12.8v10.523c-24.517,4.027-41.244,19.615-41.244,40.01v7.432
        C56.036,250.516,72.462,265.612,97.28,269.454z M122.88,271.871c8.85,2.134,15.644,6.597,15.644,13.245v8.174
        c0,6.647-6.794,11.11-15.644,13.244V271.871z M81.636,222.693c0-6.87,6.879-11.572,15.644-13.853v34.528
        c-8.85-2.134-15.644-6.597-15.644-13.244V222.693z" />
                                <path d="M499.2,115.2H12.8C5.732,115.2,0,120.931,0,128v256c0,7.069,5.732,12.8,12.8,12.8h486.4c7.068,0,12.8-5.731,12.8-12.8
        V128C512,120.931,506.268,115.2,499.2,115.2z M486.4,371.2H25.6V140.8h460.8V371.2z" />
                                <path d="M218.24,215.68h131.84c7.068,0,12.8-5.731,12.8-12.8c0-7.069-5.732-12.8-12.8-12.8H218.24c-7.068,0-12.8,5.731-12.8,12.8
        C205.44,209.949,211.172,215.68,218.24,215.68z" />
                                <path d="M218.24,266.88H438.4c7.068,0,12.8-5.731,12.8-12.8c0-7.069-5.732-12.8-12.8-12.8H218.24c-7.068,0-12.8,5.731-12.8,12.8
        C205.44,261.149,211.172,266.88,218.24,266.88z" />
                                <path d="M438.4,292.48h-74.24c-7.068,0-12.8,5.731-12.8,12.8c0,7.069,5.732,12.8,12.8,12.8h74.24c7.068,0,12.8-5.731,12.8-12.8
        C451.2,298.211,445.468,292.48,438.4,292.48z" />
                            </svg>


                        </div>
                        <h3 class="_setting_head">Payment Methods</h3>
                        <span>Recieve money on your bank or wallet.</span>
                    </a>
                </div>
                <div class="_setting_box">
                    <a href="{{ route('setting.preferences') }}">
                        <div>

                            <?xml version="1.0" ?><svg width="50px" height="50px" viewBox="0 0 32 32"
                                enable-background="new 0 0 32 32" id="Stock_cut" version="1.1" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <desc />
                                <g>
                                    <circle cx="5" cy="8" fill="none" r="2" stroke="#000000" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="2" />
                                    <line fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                        stroke-width="2" x1="7" x2="32" y1="8" y2="8" />
                                    <circle cx="5" cy="24" fill="none" r="2" stroke="#000000" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="2" />
                                    <line fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                        stroke-width="2" x1="7" x2="32" y1="24" y2="24" />
                                    <circle cx="27" cy="16" fill="none" r="2" stroke="#000000" stroke-linejoin="round"
                                        stroke-miterlimit="10" stroke-width="2" />
                                    <line fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                        stroke-width="2" x1="25" x2="0" y1="16" y2="16" />
                                    <line fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                        stroke-width="2" x1="3" x2="0" y1="8" y2="8" />
                                    <line fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                        stroke-width="2" x1="29" x2="32" y1="16" y2="16" />
                                    <line fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                        stroke-width="2" x1="3" x2="0" y1="24" y2="24" />
                                </g>
                            </svg>
                        </div>
                        
                        <h3 class="_setting_head">Global preferences</h3>
                        <span>Set your default currency and timezone.</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
