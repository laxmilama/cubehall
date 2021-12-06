<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Save;
use App\Models\ProductList;
use App\Models\ShowOff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "sdfsdf";
        return Board::where('user_id', Auth::user()->id)->latest()->get();
    }

    public function userBoard(){  
        $boards = Board::where('user_id', Auth::user()->id)->latest()->get();
        return view('board.index', [
            'boards' => $boards,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return ($request);
        $board = new Board;
        $board->name = $request->name;        
        $board->private= $request->visibility;
        $board->user_id =Auth::user()->id;
        $board->slug = $this->generateUniqId();
        $board->save();
        return $board;
    }

    public function generateUniqId(){

        $characters = '-_abcdefghijklmnopqrstuvwxyz-_0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $base  = strlen($characters) - 1;
        $output = "";
        $len = mt_rand(8, 10);
        for($i = 0; $i<$len; $i++){
            $output = $output.$characters[mt_rand(0, $base)];
        }
        
        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        // return $board;
        if($board->private =="true"){
            if(Auth::check()){
                if($board->user_id != Auth::user()->id){
                    abort(404);
                }
            }else{
                abort(404);
            }
        }


        
        // $board = Board::where('id', $board->id)->with('owner')->get();

        // return $board;
        $savedShowOff = Save::where('board_id', $board->id)->where('item_type', 'App\Models\ShowOff')->pluck('item_id');
        $showoffs = ShowOff::whereIn('id', $savedShowOff)->latest()->get();


        $savedProduct = Save::where('board_id', $board->id)->where('item_type', 'App\Models\ProductList')->pluck('item_id');
        $products = ProductList::whereIn('id', $savedProduct)->latest()->get();

        $combined = $products->concat ($showoffs)->sortBy([
            ['created_at', 'desc'],
        ]);


        // return $combined;

        return view('board.show', [
            'saves' => $combined,
            'board' => $board,
            'owner' =>$board->owner
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        if($board->is_owner == true){
            $board->delete();
            return response("Success", 200);
        }else{
            return response("Unauthorized", 401);
        }
    }


    public function update(Board $board, Request $request){
        $request->validate(
            [
                'name' => 'required|string',
                'privacy' => 'required|string'
            
            ]
            );
        
        if($board && Auth::check()){
            if($board->user_id == Auth::user()->id){
                if($request->privacy){
                    if($request->privacy)
                    Board::where('slug', $board->slug)->update(['name' => htmlentities($request->name), 'private' => $request->privacy]);
                }
                Board::where('slug', $board->slug)->update(['name' => $request->name]);
            return response('success', 200);
            }
        }else{
            return response("failed", 400);
        }
    }
}
