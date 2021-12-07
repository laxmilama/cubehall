<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Story;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ImageController;
use App\Models\Comment;
use App\Models\follow;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryController;
use App\Models\History;
use App\Notifications\StoryReactNotification;

class StoryController extends Controller
{
    protected $ImageController;

    public function __construct(ImageController $imageController, HistoryController $historyController)
    {

        $this->middleware('auth');

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
        // $stories = Story::where('created_at', '>=', Carbon::now()->subHours(24))->get()->groupBy('page_id');
        $stories = Story::with([
            'owner',
            'product' => function ($query) {
                $query->with(['meta']);
            },
            'parlor',
        ])->where('created_at', '>=', Carbon::now()->subHours(24))->orderBy('created_at', "desc")->get();
        return $stories;
    }

    public function following()
    {

        $following = follow::where('followed_by', Auth::user()->id)->pluck('followed_to');

        return Story::whereIn('page_id', $following)
            ->with(['owner', 'product' => function ($query) {
                $query->with(['meta' => function ($q) {
                    // $q->select(['thumbnail', 'page_id', 'id', 'user_id']);
                }]);
            },  'parlor', 'reactions'])
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->orderBy('created_at', "desc")
            ->get();
    }

    public function discover()
    {
        $time = 720; //in hours  24 x 30 = 720 hours = one month

        // get all the seen stories id to filter out to feed not seen stories
        $seenStories = History::where('created_at', '>=', Carbon::now()
            ->subHours($time))
            ->where('type', 'Story')
            ->where('user_id', Auth::user()->id)
            ->pluck('item_id');

        $stories = Story::whereNotIn('id', $seenStories)->with(['owner', 'product', 'parlor', 'reactions'])->where('created_at', '>=', Carbon::now()->subHours($time))->inRandomOrder()->get();

        if (count($stories) < 4) {
            $stories = Story::with(['owner', 'product.meta', 'parlor', 'reactions'])->where('created_at', '>=', Carbon::now()->subHours($time * 6))->inRandomOrder()->limit(15)->get();
        }
        return $stories->paginate(16);
    }

    public function indexbyid($id)
    {
        $page = Page::find($id);
        $stories = $page->stories()->get();
        return $stories;
    }

    public function seen(Request $request)
    {
        $this->HistoryController->store($request->storyId, 'App\Models\Story', $request->ownerId);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function media(Request $request)
    {
        // return $request;
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:20048',
        ]);

        

        $filename = $this->ImageController->store($request->file->path(), false, 'story');       
        if ($filename == 405) {
            return response('invalid aspected ratio', 405);
        }

        return response()->json(['image' => $filename]);
    }


    public function store(Request $request)
    {

        $data = json_decode($request->data);
        $data->user_id;
        // return $filename;

        $story = new Story;
        $story->media = $data->media;
        $story->product_id = $data->product_id;
        $story->user_id = $data->user_id;
        $story->page_id = $data->page_id;
        $story->parlor_id = $data->parlor_id;
        $story->save();
       

        return response('Success', 200);
    }



    public function comments($id)
    {
        // return $id;

        $comments = Comment::with(['owner'])
        ->where('item_id', $id)
        ->where('parent_id', 0)
        ->where('type', 'Story')
        ->latest()
        ->get();
        return $comments;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function viewed(Request $request)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
    }
}
