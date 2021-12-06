<?php

namespace App\Http\Controllers;

use App\Models\Parlor;
use App\Models\ParlorBook;
use App\Models\ParlorReview;
use App\Notifications\ParlorReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParlorReviewController extends Controller
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
        $request->validate([
            "content" => "string|required|max:1000",
            "ticket" => "required|numeric",
            "parlor" => "required|numeric",
            "rating" => "required|numeric",
            "booked" => "required|numeric",
        ]);

        $book = ParlorBook::where("ticket_id", $request->ticket)
            ->where("user_id", Auth::user()->id)->firstOrFail();
        $review = ParlorReview::where('booked_id', $request->booked)->first();

        if($review){
            return response('review exist', 429);
        }

        if ($book) {
            $parlor = Parlor::find($request->parlor);
             $studio=$parlor->owner->user;
            //return $studio;
            if($parlor){
                $review = new ParlorReview();
                $review->parlor_id = $request->parlor;
                $review->rating = $request->rating;
                $review->user_id = Auth::user()->id;
                // $review->ticket_id = $request->ticket;
                $review->page_id = $parlor->page_id;
                $review->review = $request->content;
                $review->booked_id = $request->booked;
                $review->save();

                foreach($studio as $s){
                    $s->notify(new ParlorReviewNotification($review,Auth::user()));
                    }
                    
                return response('success', 200);
            }
           
           
            return response("404", 404);
          
        }
        return response("Not allowed", 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParlorReview  $parlorReview
     * @return \Illuminate\Http\Response
     */
    public function show(ParlorReview $parlorReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ParlorReview  $parlorReview
     * @return \Illuminate\Http\Response
     */
    public function edit(ParlorReview $parlorReview)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParlorReview  $parlorReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParlorReview $parlorReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParlorReview  $parlorReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParlorReview $parlorReview)
    {
        //
    }
}
