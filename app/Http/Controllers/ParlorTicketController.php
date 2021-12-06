<?php

namespace App\Http\Controllers;

use App\Models\follow;
use App\Models\Page;
use App\Models\Parlor;
use App\Models\ParlorBook;
use App\Models\ParlorTicket;
use App\Models\User;
use App\Notifications\NewParlorNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParlorTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcoming(Parlor $parlor)
    {
        return ParlorTicket::where('parlor_id', $parlor->id)
            ->where('time', '>', Carbon::now())
            ->orderBy('time')
            ->paginate(10);
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
        // return $request;
        $request->validate([
            'parlorID' => 'required|numeric',
            'ticket' => 'required|string',
            'price' => 'required|numeric',
            'time' => 'required',
            'duration' => 'required|numeric',
            'guest' => 'required|numeric',
        ]);

        $parlor = Parlor::where('id', $request->parlorID)
            ->firstOrFail();
        //  return $request->parlorID;
        $tickets = ParlorTicket::where('parlor_id', $parlor->id)->get();

        $studio = Page::where('id', $parlor->page_id)->firstOrFail();
        $follow = follow::where('followed_to', $studio->id)->pluck('followed_by')->toArray();
        $follows = User::whereIn('id', $follow)->select('id', 'name', 'slug')->get();

        if ($parlor->user_id == Auth::user()->id) {

            $ticket = new ParlorTicket();
            $ticket->parlor_id = $request->parlorID;
            $ticket->price = $request->price;
            $ticket->time = $request->time;
            $ticket->duration = $request->duration;
            $ticket->capacity = $request->guest;
            $ticket->ticket = $request->ticket;
            $ticket->save();

            if (count($tickets) == 0) {
                foreach ($follows as $user) {

                    $user->notify(new NewParlorNotification($parlor));
                }
            }

            return $ticket;
        } else {
            return response('Falied!', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParlorTicket  $parlorTicket
     * @return \Illuminate\Http\Response
     */
    public function show(ParlorTicket $parlorTicket, ParlorBook $bookedId)
    { 
        if($parlorTicket->can_attend)
        {
            if($parlorTicket->id == $bookedId->ticket_id)
            {
                ParlorBook::where('id', $bookedId->id)->update(['attended_at' => Carbon::now()]);
                return $parlorTicket->ticket;
            }else{
                return response('Unauthorized Access', 405);
            }            
        }
        return response('Unauthorized Access', 405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ParlorTicket  $parlorTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(ParlorTicket $parlorTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParlorTicket  $parlorTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParlorTicket $parlorTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParlorTicket  $parlorTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParlorTicket $parlorTicket)
    {
        //
    }
}
