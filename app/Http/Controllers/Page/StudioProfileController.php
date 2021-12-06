<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudioProfile;
use App\Http\Controllers\ImageController;

class StudioProfileController extends Controller
{
    protected $ImageController;

    public function __construct(ImageController $imageController){
        $this->ImageController = $imageController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
            'studioId'=>'required|numeric',
        ]);

        $filename = $this->ImageController->store($request->image->path(), true, 'profile');

        $profile = new StudioProfile;
        $profile->image = $filename;
        $profile->page_id = $request->studioId;
        $profile->save();

        return response()->json(['image'=>$filename]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudioProfile  $studioProfile
     * @return \Illuminate\Http\Response
     */
    public function show(StudioProfile $studioProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudioProfile  $studioProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(StudioProfile $studioProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudioProfile  $studioProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudioProfile $studioProfile)
    {
        //
    }
}

