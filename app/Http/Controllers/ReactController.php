<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReactResource;
use App\Models\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReactResource::collection(Cache::remember('reactions', 60*60*24*30, function () {
            return React::all();
        }));
        // return React::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function show(React $react)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function edit(React $react)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, React $react)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function destroy(React $react)
    {
        //
    }
}
