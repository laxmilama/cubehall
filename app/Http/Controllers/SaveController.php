<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveController extends Controller
{
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
        $board = new Save;
        $board->user_id =  Auth::user()->id;
        $board->item_id = $request->itemId;
        $board->item_type = $request->type;
        $board->board_id = $request->boardId;
        $board->save();
        
        return $board;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function show(Save $save)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // return $request;
        DB::table('saves')->where('user_id', Auth::user()->id)->where('item_type', $request->type)->where('item_id', $request->itemId)->delete();
        return 'OK';
    }
}
