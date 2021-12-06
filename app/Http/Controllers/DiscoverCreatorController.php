<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscoverCreatorResource;
use App\Models\Page;
use App\Models\ProductList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DiscoverCreatorController extends Controller
{

    public function index()
    {
        return DiscoverCreatorResource::collection(Cache::remember('DiscoverCreators', 1, function () {
            $pages = Page::whereHas('atleastOneProduct')
                ->orWhereHas('atleastOneProduct')
                ->get()->shuffle();
            return $pages;
        }))->paginate(10);
    }
}
