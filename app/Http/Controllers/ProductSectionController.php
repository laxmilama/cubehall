<?php

namespace App\Http\Controllers;

use App\Models\PageCategory;
use App\Models\ProductSection;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($studio)
    {
        return PageCategory::where('page_id', $studio)
            ->select('id', 'name')
            ->where('status', 1)
            ->get();
    }

    public function available()
    {
        return Section::with(['categories' => function ($query) {
            $query->with(['subcategories' => function ($q) {
                $q->whereHas('product');
            }]);

            $query->whereHas('subcategories', function ($q) {
                $q->whereHas('product');
            });
        }])
            ->whereHas('categories', function ($query) {
                    $query->whereHas('subcategories', function($p){
                        $p->whereHas('product');
                    });
            })
            ->get();
    }
}
