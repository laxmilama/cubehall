@extends('layouts.shop')

@section('title')
    Design Agency
@endsection

@section('content')
    <?php use App\Models\ProductList; ?>
    <div class="container">

        <div class="row">
            <div data-init="searchFilter">
                <search-filter></search-filter>
            </div>
            <div class="_SCH_grid">

                

            </div>
        </div>
    </div>

@endsection
