<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscoverPeopleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DiscoverPeopleController extends Controller
{
    public function index()
    {
        // return  User::whereHas('atleastOneShowoff')->with('fiveShowoffs')->get();
                
        return DiscoverPeopleResource::collection(Cache::remember('PeopleDiscover__', 1, function () {
            return User::whereHas('atleastOneShowoff')->get()->shuffle();
        }))->paginate(10);
    }
}
