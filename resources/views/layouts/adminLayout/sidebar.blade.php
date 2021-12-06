<div class="eco_container">
    <div class="admin_sidebar flex_sidebar" id="collapsible">
        <div class="fixed_bar">
            <div id="profile" class="admin-profile mt-m mb-s">
                <a href="{{ route('home') . '/' . Auth::user()->pages->first()->slug }}">
                    <div class="admin-side-pro round_full ">
                        <img class="as-img"
                            src="{{ asset('/images/profile/thumb/' . Auth::user()->pages->first()->profile_image) }}"
                            alt="">

                    </div>
                    <div class="as-link mt-s">
                        <div class="std-name">
                            {{ Auth::user()->pages->first()->name }}

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-arrow-up-right">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>


                        </div>
                        <div>
                            <span class="typography-caption fw700">Your Studio</span>
                        </div>
                    </div>
                </a>
            </div>
            <ul class="ad-pad">
                <li class="round_c_s"><a href="{{ route('dashboard') }}"
                        class="{{ url()->current() == route('dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="admin-icon">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        Dashboard</a>
                </li>
                @canany(['isAd', 'isMa'])
                    <li class="round_c_s"><a href="{{ asset('studio/product-list') }}"
                            class="{{ url()->current() == route('ProductList') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="admin-icon">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            Listing</a></li>
                @endcanany
                @canany(['isAd', 'isMa'])
                    <li class="round_c_s"><a href="{{ route('studio.parlors') }}"
                            class="{{ url()->current() == route('studio.parlors') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="admin-icon">
                                <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                <line x1="6" y1="1" x2="6" y2="4"></line>
                                <line x1="10" y1="1" x2="10" y2="4"></line>
                                <line x1="14" y1="1" x2="14" y2="4"></line>
                            </svg>
                            Parlor</a></li>
                @endcanany
                @canany(['isAd', 'isMa'])
                    <li class="round_c_s"><a href="{{ route('order') }}"
                            class="{{ url()->current() == route('order') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="admin-icon">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Order & Shipping</a></li>
                @endcanany

                @canany(['isAd', 'isMa', 'isCEd'])
                    <li class="round_c_s">
                        <a href="{{ route('studio.analytics') }}"
                            class="{{ url()->current() == route('studio.analytics') ? 'active' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="admin-icon">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            Analytics</a>
                    </li>
                @endcanany
                @canany(['isAd', 'isMa'])
                    <li class="round_c_s">
                        <a href="{{ route('studio.review') }}"
                            class="{{ url()->current() == route('studio.review') ? 'active' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="admin-icon">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Reviews
                        </a>
                    </li>
                @endcanany

                

                @can('isAd')
                    <li class="round_c_s">
                        <a href="{{ route('studio.coupon') }}"
                            class="{{ url()->current() == route('studio.coupon') ? 'active' : '' }}">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round" class="admin-icon">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0 6C0 4.89543 0.895431 4 2 4H22C23.1046 4 24 4.89543 24 6V8C24 9.15251 23.0762 9.85628 22.3453 10.1093C21.5609 10.3809 21 11.1262 21 12C21 12.8738 21.5609 13.6191 22.3453 13.8907C23.0762 14.1437 24 14.8475 24 16V18C24 19.1046 23.1046 20 22 20H2C0.895432 20 0 19.1046 0 18V16C0 14.8475 0.923793 14.1437 1.65473 13.8907C2.43909 13.6191 3 12.8738 3 12C3 11.1262 2.43909 10.3809 1.65473 10.1093C0.923795 9.85628 0 9.15251 0 8V6ZM14 6H2V7.99732C2.00263 8.00484 2.01143 8.02257 2.03721 8.05111C2.09031 8.10987 2.18601 8.1768 2.30906 8.2194C3.87398 8.76121 5 10.2478 5 12C5 13.7522 3.87397 15.2388 2.30906 15.7806C2.18601 15.8232 2.09031 15.8901 2.03721 15.9489C2.01143 15.9774 2.00263 15.9952 2 16.0027V18H14V17C14 16.4477 14.4477 16 15 16C15.5523 16 16 16.4477 16 17V18H22V16.0027C21.9974 15.9952 21.9886 15.9774 21.9628 15.9489C21.9097 15.8901 21.814 15.8232 21.6909 15.7806C20.126 15.2388 19 13.7522 19 12C19 10.2478 20.126 8.7612 21.6909 8.2194C21.814 8.1768 21.9097 8.10987 21.9628 8.05111C21.9886 8.02257 21.9974 8.00484 22 7.99732V6H16V7C16 7.55228 15.5523 8 15 8C14.4477 8 14 7.55228 14 7V6ZM15 10C15.5523 10 16 10.4477 16 11V13C16 13.5523 15.5523 14 15 14C14.4477 14 14 13.5523 14 13V11C14 10.4477 14.4477 10 15 10Z"
                                        fill="#293644" />
                                </svg>

                            </span>Coupon</a>
                    </li>
                @endcan

                @can('isAd')
                    <li class="round_c_s">
                        <a href="{{ route('studio.finance') }}"
                            class="{{ url()->current() == route('createParlor') ? 'active' : '' }}"><span>

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="admin-icon">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg></span>Finance</a>
                    </li>
                @endcan

                @can('isAd')
                    <li class="round_c_s">
                        <a href="{{ route('studio.customize') }}"
                            class="{{ url()->current() == route('studio.customize') ? 'active' : '' }}"><span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="admin-icon">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                    </path>
                                </svg>
                                Settings</a>
                    </li>
                @endcan

            </ul>
        </div>
    </div>
