<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Page;
use App\Models\User;
use App\Models\StudioColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioCustomize extends Controller
{
    //
    public function show()
    {
        if (Gate::allows('isPage', Auth::user())) {
            $studio = Auth::user()->pages;
        } else {
            return redirect()->back();
        }
        return view('settings.studio.customize', ['studio' => $studio[0]]);
    }

    public function validateHandle(Request $request)
    {
        if (preg_match("/^[a-z\d_-]{6,30}$/i", $request->handle)) {
            $query = Page::where('slug', $request->handle)->first();
            if ($query) {
                return response('invalid', 403);
            }
            return response("ok", 200);
        }
        return response('failed', 403);
    }

    public function updateHandle(Request $request)
    {
        if (preg_match("/^[a-z\d_-]{6,30}$/i", $request->handle)) {
            $studio = Page::where('slug', $request->handle)->get();
            if (count($studio) == 0) {
                $query = Page::where('id', $request->studioId)->update(['slug' => $request->handle]);

                return response(["ok" => $query]);
            }else{
                return response('Failed!', 400);
            }
        }
    }
    public function updateName(Request $request)
    {
        $request->validate([
            'studioId' => 'required|numeric',
            'name' => 'required|string',
        ]);

        $query = Page::where('id', $request->studioId)->update(['name' => $request->name]);

        return $query;
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'studioId' => 'required|numeric',
            'about' => 'required|string',
        ]);

        $query = Page::where('id', $request->studioId)->update(['meta_description' => $request->about]);

        return $query;
    }

    public function storeColor(Request $request)
    {
        $request->validate([
            'studioId' => 'required|numeric',
            'color' => 'required|regex:/#([a-f0-9]{3}){1,2}\b/i',
        ]);
        $color = new StudioColor;
        $color->color = $request->color;
        $color->page_id = $request->studioId;
        $color->save();

        return response()->json(["color" => $request->color]);
    }
}
