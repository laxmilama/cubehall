<?php

namespace App\Http\Controllers;

use App\Models\Parlor;
use App\Models\ParlorBook;
use App\Models\ParlorTicket;
use App\Models\User;
use App\Notifications\ParlorBookNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParlorBookController extends Controller
{
    public function index()
    {
        $book = ParlorBook::with(['ticket' => function ($query) {
            $query->select('id', 'parlor_id', 'time',)
                ->with(['parlor' => function ($query) {
                    $query->select('id', 'title', 'slug', 'cover', 'user_id')
                        ->with(['host']);
                }]);
        }, 'review'])
            ->whereHas('ticket', function ($query) {
                $query->where('time', '<', Carbon::now());
            })
            ->where('user_id', Auth::user()->id)
            ->select('id', 'user_id', 'ticket_id', 'parlor_id', 'total_amount', 'quantity', 'attended_at')
            ->get();
            

        $upcoming = ParlorBook::with(['ticket' => function ($query) {
            $query->select('id', 'parlor_id', 'time')->orderBy('time')
                ->with(['parlor' => function ($query) {
                    $query->select('id', 'title', 'slug', 'cover', 'user_id', 'languages')
                        ->with(['host']);
                }]);
        }])
            ->where('user_id', Auth::user()->id)
            ->whereHas('ticket', function ($query) {
                $query->where('time', '>=', Carbon::now()->subMinutes(15));
            })
            ->select('id', 'user_id', 'ticket_id', 'parlor_id', 'total_amount', 'quantity')
            // ->orderBy('ticket.time', 'DESC')
            ->get();

        // return $upcoming;

        return view('ticket.show', [
            'upcoming' => $upcoming,
            'tickets' => $book
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
        // return $request;

        // Validate request Data;
        $request->validate([
            'userID' => 'required|numeric',
            'parlorID' => 'required|numeric',
            'ticketID' => 'required|numeric',
            'guest' => 'required|numeric',
        ]);

        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => $request->totalAmount * 100
        ));

        $ticket = ParlorTicket::find($request->ticketID);

        if($ticket->sells_count >= $ticket->capacity){
            return response($ticket->capacity, 400);
        }

        $book = ParlorBook::where('ticket_id', $request->ticketID)
            ->where('user_id', $request->userID)->first();
        if($book){
            return response('exist', 429);
        }
        
        // do not use payment methods for free tickets
        if($request->token == "reserveTicket"){
            // return $request->ticketID;
            if($ticket->price == 0){
                $book = new ParlorBook();
                $book->user_id = $request->userID;
                $book->parlor_id = $request->parlorID;
                $book->ticket_id = $request->ticketID;
                $book->quantity = $request->guest;
                $book->total_amount = $request->totalAmount;
                $book->status = 1;
                $book->payment = $request->method;
                $book->save();
                // $book->parlor->host->notify(new ParlorBookNotification($book));
                return response('success', 200);
            }else{
                return response('failed', 400);
            }
        }
        if ($request->method == "Khalti") {

            $url = "https://khalti.com/api/v2/payment/verify/";

            # Make the call using API.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $headers = ['Authorization: Key test_secret_key_4ec675868b2b4cd4b32528a81e931c2d'];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Response
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $res = json_decode($response, true); //decode the response

            // return $res;
            if (isset($res['idx']))  //check whether there is idx and also the amount in response with your database(I havenot done that)
            {
                $book = new ParlorBook();
                $book->user_id = $request->userID;
                $book->parlor_id = $request->parlorID;
                $book->ticket_id = $request->ticketID;
                $book->quantity = $request->guest;
                $book->total_amount = $request->totalAmount;
                $book->status = 1;
                $book->payment = $request->method;
                $book->save();

                $book->parlor->host->notify(new ParlorBookNotification($book));

                return response('success', 200);
            }
        }
        return response('failed', 401);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParlorBook  $parlorBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParlorBook $parlorBook)
    {
        //
    }
}
