<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserNotificationController extends Controller
{
    public function unread(){
        return Auth::user()->unreadNotifications;
    }

    // Index all read or unread notifications.
    public function all(){    
        return NotificationResources::collection(Cache::remember('notifications', 10, function () {
            return DB::table('notifications')
                ->where('notifiable_id', Auth::user()->id)
                ->where('notifiable_type', "App\Models\User")
                ->orderByDesc('created_at')
                ->distinct()
                ->get();
        }))->paginate(10);
    }
}
