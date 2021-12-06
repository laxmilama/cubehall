<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSettingResources;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{
    //
    public function show()
    {
        return view('settings.user.show');
    }

    public function personal()
    {
        $id = Auth::user()->id;
        $user =  new UserSettingResources(User::findOrFail($id));
        // return $user;
        return view('settings.user.personal', [
            'person' => json_encode($user)
        ]);
    }

    public function updateName(Request $request)
    {
        if ($request->userId == Auth::user()->id) {
            $request->validate([
                'userId' => 'required|numeric',
                'name' => 'required|string',
            ]);

            $query = User::where('id', $request->userId)->update(['name' => $request->name]);

            return $query;
        }
    }

    public function validateHandle(Request $request)
    {
        $request->validate([
            'handle' => 'required|string|max:30',
        ]);
        $query = User::where('slug', $request->handle)->first();

        if ($query) {
            return response()->json(200);
        }
        return response()->json(400);
    }

    public function updateHandle(Request $request)
    {
        $request->validate([
            'handle' => 'required|string|max:30',
            'userId' => 'required|numeric'
        ]);

        if ($request->userId == Auth::user()->id) {
            if (preg_match("/^[a-z\d_-]{6,30}$/i", $request->handle)) {
                $query = User::where('id', $request->userId)->update(['slug' => $request->handle]);

                return response(["ok" => $query]);
            }
        } else {
            return response()->json(["Failed", 401]);
        }
    }

    public function gov()
    {
        return view('settings.user.KYC.show');
    }
}
