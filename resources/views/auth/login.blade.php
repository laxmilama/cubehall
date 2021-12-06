@extends('layouts.login')
@section('title')
    Login to Crafto
@endsection
@section('content')
    <div class="lg-form">
        {{-- <img class="form-bg" src="{{asset('img/hans-m-q4Gmk6X_z7o-unsplash.jpg')}}" alt=""> --}}
       
        <div class="form-panel">
            <div class="form-card">
                <div class="round_c_m f-c-wrap">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('home') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="140" height="36" viewBox="0 0 124 30"
                                    fill="none" style="enable-background:new 0 0 124.3 32.7;" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="nav_logo_ form-logo">
                                    <g>
                                        <g>
                                            <path
                                                d="M12.8,27.4H2.7c-1.3,0-2.4-1.1-2.4-2.4V14.8c0-1.9,1.6-3.5,3.5-3.5h2c2,0,3.6,1.6,3.6,3.6v2.8c0,0.4,0.3,0.7,0.7,0.7h2.7
                                           c2,0,3.6,1.6,3.6,3.6v1.9C16.5,25.8,14.8,27.4,12.8,27.4z M3.9,13c-1,0-1.8,0.8-1.8,1.8V25c0,0.4,0.3,0.7,0.7,0.7h10.1
                                           c1,0,1.9-0.9,1.9-1.9v-1.9c0-1.1-0.9-1.9-1.9-1.9h-2.7c-1.3,0-2.4-1.1-2.4-2.4v-2.8c0-1.1-0.9-1.9-1.9-1.9H3.9z" />
                                        </g>
                                        <path d="M20.4,27.4c-0.3,0-0.5-0.1-0.8-0.2c-0.8-0.3-1.3-1.1-1.3-2V9.8c0-0.2-0.2-0.4-0.4-0.4H2.5c-0.9,0-1.6-0.5-2-1.3
                                       C0.2,7.3,0.4,6.4,1,5.8l4.9-4.9c0.4-0.4,0.9-0.6,1.5-0.6h18c1.2,0,2.1,0.9,2.1,2.1v18c0,0.6-0.2,1.1-0.6,1.5l-4.9,4.9
                                       C21.5,27.2,21,27.4,20.4,27.4z M7.4,2c-0.1,0-0.2,0-0.3,0.1L2.2,7.1C2,7.2,2.1,7.4,2.1,7.5c0,0.1,0.1,0.2,0.4,0.2h15.4
                                       c1.2,0,2.1,0.9,2.1,2.1v15.5c0,0.2,0.1,0.3,0.2,0.4c0.1,0,0.3,0.1,0.4-0.1l4.9-4.9c0.1-0.1,0.1-0.2,0.1-0.3v-18
                                       c0-0.2-0.2-0.4-0.4-0.4H7.4z" />
                                    </g>
                                    <g>
                                        <path d="M42.1,21.9c-0.8,0-1.7-0.1-2.4-0.4c-0.8-0.3-1.4-0.6-2-1.1c-0.6-0.5-1.1-1-1.6-1.6c-0.4-0.6-0.8-1.3-1-2.1
                                       c-0.2-0.8-0.4-1.6-0.4-2.5c0-0.9,0.1-1.7,0.4-2.5c0.2-0.8,0.6-1.5,1-2.2c0.4-0.7,1-1.2,1.6-1.7c0.6-0.5,1.3-0.8,2-1.1
                                       c0.7-0.3,1.5-0.4,2.4-0.4c0.8,0,1.5,0.1,2.2,0.3c0.7,0.2,1.3,0.5,1.9,0.9c0.6,0.4,1,0.9,1.5,1.4c0.4,0.5,0.7,1.2,0.9,1.8l-3,0.8
                                       c-0.3-0.7-0.8-1.3-1.4-1.7C43.5,9.3,42.8,9,42,9c-0.6,0-1.1,0.1-1.6,0.4c-0.5,0.3-0.9,0.6-1.3,1.1c-0.4,0.5-0.7,1-0.9,1.6
                                       c-0.2,0.6-0.3,1.3-0.3,2c0,0.7,0.1,1.4,0.3,2c0.2,0.6,0.5,1.1,0.9,1.6c0.4,0.4,0.8,0.8,1.3,1c0.5,0.2,1.1,0.4,1.7,0.4
                                       c0.8,0,1.5-0.2,2.1-0.6c0.6-0.4,1.1-1,1.5-1.7l3,0.8c-0.3,0.9-0.8,1.7-1.4,2.4c-0.6,0.7-1.4,1.2-2.3,1.5
                                       C44.1,21.7,43.1,21.9,42.1,21.9z" />
                                        <path d="M55.4,21.8c-1,0-1.9-0.2-2.6-0.6c-0.7-0.4-1.3-1-1.7-1.8c-0.4-0.8-0.6-1.7-0.6-2.8v-6.1h2.9v6.2c0,0.8,0.2,1.4,0.6,1.9
                                       c0.4,0.5,0.9,0.7,1.5,0.7c0.6,0,1.1-0.2,1.5-0.7c0.4-0.5,0.6-1.1,0.6-1.9v-6.2h2.9v6.1c0,0.8-0.1,1.5-0.4,2.2
                                       c-0.2,0.6-0.6,1.2-1,1.7c-0.4,0.5-1,0.8-1.6,1.1C56.9,21.6,56.2,21.8,55.4,21.8z" />
                                        <path d="M62.8,21.4V5.9h2.9v6c0.4-0.5,0.9-0.9,1.5-1.3c0.6-0.3,1.2-0.5,2-0.5c0.7,0,1.4,0.1,2,0.4c0.6,0.3,1.1,0.7,1.6,1.2
                                       c0.5,0.5,0.8,1.1,1.1,1.8c0.3,0.7,0.4,1.5,0.4,2.3c0,0.8-0.1,1.6-0.4,2.3c-0.3,0.7-0.6,1.3-1.1,1.9c-0.5,0.5-1,1-1.7,1.3
                                       c-0.6,0.3-1.3,0.4-2.1,0.4c-0.7,0-1.4-0.2-2-0.5C66.5,21,66,20.6,65.6,20l-0.1,1.4H62.8z M68.5,19.1c0.5,0,1-0.1,1.4-0.4
                                       c0.4-0.3,0.7-0.7,1-1.1c0.2-0.5,0.4-1,0.4-1.6c0-0.6-0.1-1.2-0.4-1.6c-0.2-0.5-0.6-0.9-1-1.1c-0.4-0.3-0.9-0.4-1.4-0.4
                                       c-0.5,0-1,0.1-1.4,0.4c-0.4,0.3-0.7,0.7-1,1.1c-0.2,0.5-0.4,1-0.4,1.6c0,0.6,0.1,1.2,0.4,1.6c0.2,0.5,0.6,0.9,1,1.1
                                       C67.5,19,68,19.1,68.5,19.1z" />
                                        <path d="M81.5,21.8c-0.8,0-1.6-0.1-2.3-0.4c-0.7-0.3-1.3-0.7-1.8-1.2c-0.5-0.5-0.9-1.1-1.2-1.9c-0.3-0.7-0.4-1.5-0.4-2.4
                                       c0-0.8,0.1-1.6,0.4-2.3c0.3-0.7,0.7-1.3,1.2-1.8c0.5-0.5,1.1-0.9,1.7-1.2c0.7-0.3,1.4-0.4,2.2-0.4c0.8,0,1.5,0.1,2.2,0.4
                                       c0.7,0.3,1.2,0.7,1.7,1.2c0.5,0.5,0.8,1.1,1.1,1.8c0.3,0.7,0.4,1.5,0.4,2.4v0.7h-7.9c0.1,0.8,0.4,1.5,0.9,1.9
                                       c0.5,0.5,1.1,0.7,1.8,0.7c0.5,0,1-0.1,1.4-0.4c0.4-0.2,0.7-0.6,1-1l2.6,0.8c-0.3,0.6-0.6,1.2-1.1,1.6c-0.5,0.4-1.1,0.8-1.8,1
                                       C83,21.6,82.3,21.8,81.5,21.8z M81.4,12.3c-0.6,0-1.2,0.2-1.6,0.6s-0.7,1-0.9,1.7h4.9C83.6,14,83.4,13.4,83,13
                                       C82.5,12.6,82,12.3,81.4,12.3z" />
                                        <path d="M88.8,21.4V6.6h3.1v5.8h6.6V6.6h3.1v14.8h-3.1v-6.3h-6.6v6.3H88.8z" />
                                        <path
                                            d="M107.5,21.8c-0.6,0-1.1-0.1-1.6-0.3c-0.5-0.2-0.9-0.4-1.2-0.7c-0.4-0.3-0.6-0.7-0.8-1.1c-0.2-0.4-0.3-0.9-0.3-1.4
                                       c0-0.7,0.2-1.3,0.6-1.8c0.4-0.5,0.9-0.9,1.6-1.2c0.7-0.3,1.5-0.4,2.4-0.4c0.5,0,0.9,0,1.3,0.1c0.4,0.1,0.8,0.2,1.2,0.4v-0.6
                                       c0-0.6-0.2-1.1-0.5-1.5c-0.4-0.4-0.8-0.6-1.5-0.6c-0.5,0-0.9,0.1-1.3,0.3c-0.4,0.2-0.6,0.6-0.8,1l-2.6-0.5c0.2-0.6,0.5-1.2,0.9-1.7
                                       c0.5-0.5,1-0.9,1.7-1.1c0.7-0.3,1.4-0.4,2.1-0.4c0.7,0,1.4,0.1,1.9,0.3c0.6,0.2,1.1,0.5,1.5,1c0.4,0.4,0.8,0.9,1,1.5
                                       c0.2,0.6,0.3,1.2,0.3,1.9v6.7h-2.6l-0.1-1.3c-0.3,0.5-0.7,0.9-1.3,1.2C108.9,21.6,108.3,21.8,107.5,21.8z M106.5,18.2
                                       c0,0.4,0.2,0.7,0.5,1c0.3,0.3,0.7,0.4,1.3,0.4c0.5,0,0.9-0.1,1.2-0.3c0.4-0.2,0.6-0.5,0.9-0.8c0.2-0.3,0.3-0.7,0.3-1.1v-0.1
                                       c-0.3-0.1-0.6-0.2-1-0.3c-0.3-0.1-0.7-0.1-1-0.1c-0.7,0-1.2,0.1-1.6,0.4C106.6,17.4,106.5,17.7,106.5,18.2z" />
                                        <path d="M115.8,21.4V5.9h2.9v15.6H115.8z" />
                                        <path d="M121.1,21.4V5.9h2.9v15.6H121.1z" />
                                    </g>
                                </svg>
                            </a>
                        </div>

                        <div class="card-body">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                          
                                <strong>{{ $message }}</strong>
                            </div>
                         @endif
                         @if ($message = Session::get('error'))
                         <div class="alert alert-success alert-block">
                       
                             <strong>{{ $message }}</strong>
                         </div>
                      @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <span class="typography-caption alert"> <strong>{{ $errors->first('email') }}</strong></span>
                                    </span>
                                @endif
                                    {{-- @error('email')
                                        <span class="invalid-feedback">
                                            <span class="typography-caption alert">{{ $message }}</span>
                                        </span>
                                    @enderror --}}
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="f-input round_c_m" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="Email/Username">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="f-input round_c_m" name="password"
                                            required autocomplete="current-password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="no-display" type="checkbox" name="remember" id="remember"
                                                checked }}>

                                            <label class="no-display" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div>


                                    @if (Route::has('password.request'))
                                        <a class="typography-caption forget-pwd" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>


                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn-primary btn-normalize form-btn">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <style>
                            .SocialButton-Icon{
                                display: inline-block;
                                vertical-align: top;
                                height: 22px;
                                width: 22px;
                                margin-right: 10px;
                            }

                        </style>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            <a href="{{ url('auth/google') }}" class="btn-secondary btn-normalize form-btn">
                                <svg viewBox="0 0 1152 1152" focusable="false" aria-hidden="true" role="img" class="SocialButton-Icon"><path d="M1055.994 594.42a559.973 559.973 0 0 0-8.86-99.684h-458.99V683.25h262.28c-11.298 60.918-45.633 112.532-97.248 147.089v122.279h157.501c92.152-84.842 145.317-209.78 145.317-358.198z" fill="#4285f4"></path><path d="M588.144 1070.688c131.583 0 241.9-43.64 322.533-118.07l-157.5-122.28c-43.64 29.241-99.463 46.52-165.033 46.52-126.931 0-234.368-85.728-272.691-200.919H152.636v126.267c80.19 159.273 245 268.482 435.508 268.482z" fill="#34a853"></path><path d="M315.453 675.94a288.113 288.113 0 0 1 0-185.191V364.482H152.636a487.96 487.96 0 0 0 0 437.724z" fill="#fbbc05"></path><path d="M588.144 289.83c71.551 0 135.792 24.589 186.298 72.88l139.78-139.779C829.821 144.291 719.504 96 588.143 96c-190.507 0-355.318 109.21-435.508 268.482L315.453 490.75c38.323-115.19 145.76-200.919 272.691-200.919z" fill="#ea4335"></path></svg>
                            <span>


                                Continue with Google
                            </span>
                            </a>
                            </div>
                            </div>
                    </div>
                    <div>
                        <div>
                            <span class="typography-body2 extr-link">New user? <a href="{{ url('/register') }}">Create an
                                    account</a></span>
                        </div>
                    </div>
                </div>
                <div data-init="init-install">
                    <install-app type="auth"></install-app>
                </div>
            </div>
        </div>

    </div>
@endsection
