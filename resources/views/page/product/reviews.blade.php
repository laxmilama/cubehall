@extends('layouts.adminLayout.admin_design')

@section('title')
    Analytics
@endsection

@section('content')
<?php
function truncateString($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . '...';
    } else {
        return $string;
    }
}
?>
<style>
     .p_an_img_wrap {
            width: 115px;
            padding-top: 145px;
            position: relative;
            flex-shrink: 0;
        }

        .p_an_img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;

        }

        .p_an_title {
            margin-left: 20px;
        }

        .p_an_data_chart {
            width: calc(calc(100% / 4) - 16px);
            position: relative;
            margin: 8px;
        }

        .p_an_details {
            display: grid;
            grid-template-columns: auto auto auto;
        }

        .p_an_d {
            display: flex;
            align-items: center;

        }

        .p_an_counter {
            margin-top: 15px;
            display: flex;
            align-items: center;
        }

        .p_an_value {
            padding: 5px;
            font-size: 18px;
        }

        .p_an_grid {
            display: flex;
            flex-wrap: wrap;
        }

        .p_an_link {
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        @media screen and (max-width: 600px) {
            .p_an_data_chart {
                width: calc(calc(100% / 2) - 16px);
                position: relative;
                margin: 8px;
            }
        }
</style>
    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="sm-container">
            <div id="app">
                <div class="ct12">
                    <div class="mt">
                        <h1 class="thead">Product Reviews</h1>
                    </div>
                </div>
                <div class="row" style="display: inline-block;">
                    <div class="flex-box mt-m">
                        <div class="p_an_img_wrap round_c_s">

                            <img class="p_an_img"
                                src="{{ asset('images/product/small/' . $product->meta->thumbnail) }}">
                            <a class="p_an_link" href="{{ route('list', $product->slug) }}"></a>
                        </div>
                        <div class="p_an_title">
                            <h2>{{ $product->name }}</h2>
                            <p>{{ truncateString($product->description, 100) }}</p>
                            <span style="color:var(--gray-medium-dark)">Published on
                                {{ date('F d, Y', strtotime($product->created_at)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: inline-block;">
                    
                    <product-reviews slug="{{$product->slug}}"></product-reviews>
                </div>
            </div>
        </div>
    </div>
@endsection
