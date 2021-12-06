<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Parlor;
use App\Models\ProductList;
use App\Models\ProductReview;
use App\Models\Story;
use App\Models\StudioProfile;
use App\Models\User;
use Illuminate\Http\Request;


class StudioController extends Controller
{
    public function show(Page $slug)
    {
        // return $slug;
        return view('studio.show', [
            'studio' => $slug,
        ]);
    }


    public function products(Page $slug, Request $request)
    {   
        if ($request->get('coll')) {
            if ($request->get('coll') == "All") {
                return ProductList::where('page_id', $slug->id)
                    ->whereHas('meta')
                    ->with('meta')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
            } else {
                $request->validate([
                    'coll' => 'required|numeric'
                ]);

                return ProductList::where('page_id', $slug->id)
                    ->where('collection_id', $request->coll)
                    ->whereHas('meta')
                    ->with('meta')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
            }
        }
        return response("Invalid request!", 400);
    }

    public function parlors(Page $slug)
    {
        return Parlor::where('page_id', $slug->id)
            ->whereHas('ticket')
            ->with('ticket')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function reviews(Page $slug)
    {
        return ProductReview::where('page_id', $slug->id)
            ->with('writer')
            ->with('productlist')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
