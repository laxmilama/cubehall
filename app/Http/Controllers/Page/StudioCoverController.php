<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\StudioCover;

class StudioCoverController extends Controller
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

        $filename = $this->ImageController->store($request->image->path(), false, 'cover');

        $profile = new StudioCover;
        $profile->image = $filename;
        $profile->page_id = $request->studioId;
        $profile->save();

        return response()->json(['image'=>$filename]);
    }

}
