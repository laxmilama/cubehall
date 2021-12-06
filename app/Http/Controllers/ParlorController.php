<?php

namespace App\Http\Controllers;

use App\Models\Parlor;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Models\ParlorTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Http\Controllers\HistoryController;
use App\Models\SuperAdmin;
use App\Notifications\ParlorRequestNotification;

class ParlorController extends Controller
{
    protected $ImageController;

    public function __construct(ImageController $imageController, HistoryController $historyController)
    {
        $this->ImageController = $imageController;
        $this->HistoryController = $historyController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::allows('isPage', Auth::user())) {
            $studio = Auth::user()->pages;
            $parlors = Parlor::where('page_id', $studio[0]->id)->latest()->paginate(10);

            // return $parlors;

            return view('parlor.index', [
                'parlors' => $parlors
            ]);
        }
    }

    public function detail(Parlor $parlor)
    {
        if (Gate::allows('isPage', Auth::user())) {

            // return $parlor;
            $detail = Parlor::where('id', $parlor->id)->with('tickets', 'ticket', 'reviews.writer')->first();

            // return $detail;

            return view('parlor.detail', [
                'detail' => $detail
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parlor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request;

        // dd($data->title);

        $parlor = new Parlor();
        $parlor->brief = $data->brief;
        $parlor->title = $data->title;
        $parlor->slug = $data->title;
        $parlor->theme = $data->theme;
        $parlor->bringings = json_encode($data->bringings);
        $parlor->languages = json_encode($data->languages);
        $parlor->learnings = json_encode($data->learnings);
        $parlor->location = 'nepal';
        $parlor->page_id = $data->page;
        $parlor->user_id = $data->user;
        $parlor->accuracy = 1;
        $parlor->agreeterms = 1;
        $parlor->noncopyrightcontent = 1;
        $parlor->age = $data->age;
        $parlor->cover = $data->cover;
        $parlor->details = json_encode($data->details);
        $parlor->video = $data->video;
       $parlor->save();

        $admins = SuperAdmin::get();
       // return $admins;
      
            foreach ($admins as $admin) {
                // return $followtoss;
                
                $admin->notify(new ParlorRequestNotification($parlor,$admin));
                }

        return response()->json(['image' => 'Falano']);
    }

    public function uploadCover(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:20048',
        ]);

        $filename = $this->ImageController->store($request->image->path(), false, 'parlor');

        return response()->json(['image' => $filename]);
    }

    public function uploadDetails(Request $request)
    {
        $filename = $this->ImageController->multipleImages($request, false, 'parlor');

        // dd($filename);

        return response()->json(['images' => $filename]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parlor  $parlor
     * @return \Illuminate\Http\Response
     */
    public function show(Parlor $parlor)
    {
        

        $p = Parlor::where('id', $parlor->id)
            ->with(
                [
                    'owner' => function ($query) {
                        $query->select(['id', 'name', 'slug']);
                    },
                    'host' =>function ($query){
                        $query->select(['id', 'name', 'slug']);
                    },
                    'tickets' =>function ($query){
                        $query
                        ->where('time', '>=', Carbon::now())
                        ->orderBy('time');
                    },
                    'ticket',
                    'reviewsTop.writer'
                ]
            )
            ->whereHas('tickets')
            ->where('status', 1)
            ->firstOrFail();

        $parlors = Parlor::whereHas('tickets', function ($query) {
            $query->where('time', '>=',  Carbon::now()->addHours(6));
        })
            ->with('tickets')
            ->where('status', 1)
            ->select(['id', 'title', 'location', 'languages', 'slug', 'cover'])
            ->limit(10)
            ->get();

        // return $parlors;
        $this->HistoryController->store($parlor->id, $parlor->type, $parlor->page_id);

        return view('parlor.show', [
            'parlor' => $p,
            'parlors' => $parlors
        ]);
    }


    public function lists($id)
    {
        $products = Parlor::where('page_id', $id)
        ->where('status', 1)
        ->get();
        return $products;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parlor  $parlor
     * @return \Illuminate\Http\Response
     */
    public function edit(Parlor $parlor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parlor  $parlor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parlor $parlor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parlor  $parlor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parlor $parlor)
    {
        //
    }
}
