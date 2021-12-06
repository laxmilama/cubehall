@extends('layouts.shop')

@section('title')
    CubeHall products
@endsection

@section('content')
    <div class="container">
        <div style="display: inline-block; width:100%">
            <div class="mt">
                <h1>Products</h1>
            </div>
            <div class="_CAT_wrap">
                @foreach ($sections as $section)
                    <div class="_CAT_card">
                        <div class="_CAT_head">
                            <h3>
                                <span>
                                    {{ $section->name }}
                                </span>
                            </h3>
                        </div>
                        <div class="_CAT_body">
                            @foreach ($section->categories as $cat)
                                <ul class="_CAT_list_prim">
                                    <li>
                                        <a class="_CAT_a" href="{{route('category.primary', $cat->slug)}}">
                                            <span>
                                                {{ $cat->name }}
                                            </span>
                                        </a>

                                    </li>
                                    <li>
                                        @foreach ($cat->subcategories as $sub)
                                            <ul class="_CAT_list_sec">
                                                <li>
                                                    <a class="_CAT_a" href="{{route('category.secondary', ['category'=>$cat->slug, 'subcategory'=>$sub->slug])}}">
                                                        <span>
                                                            {{ $sub->name }}
                                                        </span>
                                                    </a>

                                                </li>
                                            </ul>
                                        @endforeach
                                    </li>
                                </ul>

                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
