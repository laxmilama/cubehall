@extends('layouts.adminLayout.admin_design')

@section('title')
    Reviews
@endsection
@section('content')

    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div id="app" class="sm-container">
            <div class="mt-m ">
                <h1>Reviews</h1>
            </div>
            <div class="review">
                @foreach ($reviews as $r)
                    <div class="review_wrapper">
                        <div class="review_wt">
                            <div class="review_pp">
                                <img class="review_pp_img"
                                    src="{{ asset('images/profile/thumb/' . $r->writer->profile_image) }}"
                                    alt="{{ $r->writer->name }}">
                            </div>
                            <div class="review_wt_dt">
                                <span class="review_wt_n">{{ $r->writer->name }}</span>
                                <div class="review_wt_t">{{ date('F, Y', strtotime($r->created_at)) }}</div>
                                <div>
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $r->rating)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                style="fill:var(--primary-color); stroke:var(--primary-color)">
                                                <polygon
                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                </polygon>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                style="stroke:var(--primary-color)">
                                                <polygon
                                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                </polygon>
                                            </svg>
                                        @endif
                                    @endfor

                                </div>
                            </div>
                        </div>
                        <div>
                            {{ $r->review }}
                        </div>
                        <div>
                            
                            <strong>{{$r->productlist->name}}</strong>
                            <div>
                                <img src="{{asset('images/product/thumb/'.$r->productlist->meta->thumbnail)}}" alt="{{$r->productlist->name}}">
                            </div>
                        </div>
                        
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection
