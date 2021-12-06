<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\ProductReview;

class ProductReviews extends Controller
{
    //
    public function show(ProductList $product){
        return view('page.product.reviews', [
            'product' => $product,
        ]);
    }

    public function reviews(ProductList $product){        
        return ProductReview::where('product_id', $product->id)
            ->where('status', 1)
            ->with('writer')
            ->paginate(5);
    }

    
}
