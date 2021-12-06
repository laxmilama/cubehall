<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicReviewsResources;
use App\Models\ProductList;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PublicReviewsController extends Controller
{
    public function product(ProductList $product)
    {
        $p= PublicReviewsResources::collection(Cache::remember('public_product_reviews', 60*24, function () use ($product) {
            return ProductReview::where('product_id', $product->id)->get();
        }));
        return $p->paginate(6);
    }
}
