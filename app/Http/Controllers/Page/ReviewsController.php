<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{

    public function index(){
        if(Gate::allows('isPage',Auth::user())) {
            $studio=Auth::user()->pages;
            $reviews = ProductReview::where('page_id', $studio[0]->id)->with(['writer', 'productlist.meta'])->latest()->paginate(16);
        }
        else{
            return redirect()->back();    
        }
        // return $reviews;
        return view('page.reviews',
            [
                'studio'=>$studio[0],
                "reviews"=>$reviews,
        ]);
    }
}