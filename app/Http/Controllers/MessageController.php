<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\newMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ImageController;
use App\Models\UserProfile;

class MessageController extends Controller
{

    public function __construct(ImageController $imageController)
    {

        // $this->middleware('auth');

        $this->ImageController = $imageController;
    }

    //test chat
    public function testfollow()
    {
        return view('chat');
    }




    public function fetchMessagesQuery($user_id)
    {
        return Message::where('from', Auth::user()->id)->where('to', $user_id)
            ->orWhere('from', $user_id)->where('to', Auth::user()->id);
    }

    public function getLastMessageQuery($user_id)
    {
        return $this->fetchMessagesQuery($user_id)
        ->latest()
        ->select('text')
        ->first();
    }

    public function getContactItem($user)
    {
        // get last message
        $lastMessage = $this->getLastMessageQuery($user->id);

        return $lastMessage;
    }

    public function getProfile($user)
    {
        if (UserProfile::where("user_id", $user->id)->exists()) {
            return UserProfile::where("user_id", $user->id)->latest('id')->first()->image;
        } else {
            return '303eb-e9be-3fb2a7-caf3df.webp';
        }
    }



    public function testget()
    {
        $user_id = Auth::user()->id;

        $users = Message::join('users',  function ($join) {
            $join->on('messages.from', '=', 'users.id')
                ->orOn('messages.to', '=', 'users.id');
        })
            ->where(function ($q) {
                $q->where('messages.from', Auth::user()->id)
                    ->orWhere('messages.to', Auth::user()->id);
            })
            ->where('users.id', '!=', Auth::user()->id)
            ->select('users.id','users.name','users.slug', DB::raw('MAX(messages.created_at) max_created_at'))
            ->orderBy('max_created_at', 'desc')
            ->groupBy('users.id')
            ->paginate(10);

        $usersList = $users->items();

        if (count($usersList) > 0) {
          
            foreach ($usersList as $user) {
                $user['recent'] = $this->getContactItem($user);
                $user['profile_image'] = $this->getProfile($user);
            }
        } else {
            $usersList = 'not found';
        }

       // return $usersList;

        return  response()->json(
            [
                "data" => $usersList, 
                "last_page" => $users->lastPage(), 
                "current_page" => $users->currentPage()
            ]
        );
        //}
        // return response()->json($contacts);

    }

    public function getConversation($id)
    {
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);


        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return  response()->json($messages);
    }

    public function saveConversation(Request $request)
    {
        $message = Message::create([
            'from' => auth()->user()->id,
            'to' => $request->contact_id,
            'text' => $request->text,
            'type' => $request->type,
        ]);
        broadcast(new newMessage($message));
        return response()->json($message);
    }

    public function saveImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:20048',
        ]);

        $filename = $this->ImageController->store($request->image->path(), false, 'message');

        return response()->json(['image' => $filename]);
    }
}
