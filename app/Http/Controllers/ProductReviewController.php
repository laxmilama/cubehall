<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\ProductList;
use App\Models\ProductReview;
use App\Notifications\ProductReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            "content" => "string|required|max:1000",
            "order" => "required|numeric",
            "product" => "required|numeric",
            "rating" => "required|numeric",
            'opid' => "required|numeric"
        ]);

        $order = OrderProduct::where("order_id", $request->order)
            ->where("user_id", Auth::user()->id)->firstOrFail();
        $review = ProductReview::where('order_product_id', $request->opid)->first();

        if($review){
            return response('review exist', 429);
        }

        if ($order) {
            $product = ProductList::find($request->product);
            $studio=$product->owner->users;
           // return $studio;
            // return $product->page_id;
            if($product){
                $review = new ProductReview();
                $review->product_id = $request->product;
                $review->user_id = Auth::user()->id;
                $review->page_id = $product->page_id;
                $review->order_id = $request->order;
                $review->order_product_id = $request->opid;
                $review->rating = $request->rating;                
                $review->review = $request->content;
                $review->status = 1;
                $review->save();

                foreach($studio as $s){
                    $s->notify(new ProductReviewNotification($review,Auth::user()));
                    }

                return response('success', 200);
            }
        
            return response("404", 404);
          
        }
        return response("Not allowed", 403);
    }
}
