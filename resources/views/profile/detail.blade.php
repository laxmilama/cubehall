<div class="small_container">
    <div class="p-wrap ">
        <div class="profile">
            <div class="profile-pic round_full">
                <img src="{{ asset('/images/profile/small/' . $user->profile_image) }}" alt="">
            </div>
            <div class="profile-details">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <h2 class="profile-handle">{{ '@' . $user->slug }}</h2>
                <div class="flex-box _PF_counter">
                    <div class="_PF_fC">
                        <div class="_PF_Cnt">
                            {{ $user->followers_count }}
                        </div>
                        <div>
                            <strong class="_PF_tg">Followers</strong>
                        </div>
                    </div>
                    <div class="_PF_fC">
                        <div class="_PF_Cnt">
                            {{ $user->following_count }}
                        </div>
                        <div>
                            <strong class="_PF_tg">Following</strong>
                        </div>
                    </div>
                    <div class="_PF_fC">
                        <div class="_PF_Cnt">
                            {{ $user->views }}
                        </div>
                        <div>
                            <strong class="_PF_tg">Monthly Views</strong>
                        </div>
                    </div>
                </div>
                <div>
                    {{ $user->bio }}
                </div>
                @if ($user->can('isPage'))
                    <div>
                        <span>Owns <a
                                href="/{{ $user->pages->first()->slug }}">{{ $user->pages->first()->name }}</a>
                        </span>
                    </div>
                @endif
            </div>
            <div class="flex-box">
                @if (Auth::check())
                    @if (Auth::user()->id == $user->id)
                        <a class="btn-normalize btn-secondary" href="{{ route('account.personal') }}">Edit Profile</a>
                    @else
                        <div>
                            <follow-user pid="{{$user->id}}" slug="{{$user->slug}}" is_following="{{$user->is_followed}}"></follow-user>
                        </div>
                    @endif
                @else
                    <div>
                        <follow-user pid="{{$user->id}}" slug="{{$user->slug}}" is_following="{{$user->is_followed}}"></follow-user>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div>
        <div style="display: flex; justify-content:space-between; margin-bottom: 15px;">
            <div class="flex-box">
                <div class="_PF_tab">
                    <a href="{{ route('user.show', $user->slug) }}"
                        class="{{ url()->current() == route('user.show', $user->slug) ? 'btn-normalize btn-active' : 'btn-normalize' }}"><span>Created</span></a>
                </div>
                <div class="_PF_tab">
                    <a href="{{ route('user.board', $user->slug) }}"
                        class="{{ url()->current() == route('user.board', $user->slug) ? 'btn-normalize btn-active' : 'btn-normalize' }}"><span>Saved</span></a>
                </div>
            </div>
            <div>
                @if (Auth::check())
                    @if (Auth::user()->id == $user->id)

                        @if (Auth::user()->can_showoff == true)
                            <a href="{{ route('showoff.create') }}" class="btn-create btn-normalize">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="create_showoff">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                showoff</a>
                        @endif
                    @endif

                @endif

            </div>
        </div>
    </div>
</div>
