<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\ProductList;
use App\Models\ShowOff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageController;
use App\Models\ShowOffMeta;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Resources\PublicProductResource;
use App\Models\AssociatePaid;
use App\Models\ProductMeta;
use App\ProductSimilarity;
use Carbon\Carbon;

class ShowOffController extends Controller
{

    protected $ImageController, $ShowOffMetaController, $HistoryController;

    public function __construct(ImageController $imageController, HistoryController $historyController, CurrencyController $currencyController)
    {
        $this->ImageController = $imageController;
        $this->HistoryController = $historyController;
        $this->CurrencyController = $currencyController;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            if (Auth::user()->can_showoff) {
                return view('profile.createshowoff');
            }
        }
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $off = new ShowOff();
        $off->user_id = Auth::user()->id;
        $off->title = $request->title;
        $off->description = $request->description;
        $off->media = $request->image;
        $off->mime = 'webp';
        $off->slug = $this->generateUniqId();
        $off->tags = "Tag";
        $off->save();


        foreach (json_decode($request->tags) as $tag) {
            $offmeta = new ShowOffMeta();
            $offmeta->show_off_id = $off->id;
            $offmeta->link_id = $tag->pid;
            $offmeta->type = $tag->type;
            $offmeta->left = $tag->left;
            $offmeta->top = $tag->top;
            $offmeta->url = "URL";
            $offmeta->save();
        }
        $ap = AssociatePaid::where('user_id', Auth::user()->id)->first();
        if (!$ap) {
            $paid = new AssociatePaid;
            $paid->user_id = Auth::user()->id;
            $paid->last_paid = Carbon::now();
            $paid->amount = 0;
            $paid->currency = "NPR";
            $paid->save();
        }

        return response($off->slug, 200);
    }

    public function generateUniqId()
    {

        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $base  = strlen($characters) - 1;
        $output = "";
        $len = 12;
        for ($i = 0; $i < $len; $i++) {
            $output = $output . $characters[mt_rand(0, $base)];
        }

        return $output;
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:20048',
        ]);

        $filename = $this->ImageController->store($request->image->path(), false, 'showoff');

        // return $filename;
        if ($filename == 405) {
            return response('invalid aspected ratio', 405);
        }

        return response()->json(['image' => $filename]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShowOff  $showOff
     * @return \Illuminate\Http\Response
     */
    public function show($showOff)
    {


        // return $showOff->tagged();

        // return $showOff;

        $showoff =  ShowOff::with(['owner', 'tagged' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->select(['id', 'name', 'slug'])
                    ->with(['meta' => function ($query) {
                    }]);
            }])
                ->whereHas('product')->get();
        }])
            ->whereHas('tagged')
            ->where('slug', $showOff)
            ->firstOrFail();

        // return $showoff;

        // return json_encode($showoff);


        $products = json_decode(ShowOff::whereHas('tagged')->latest()->get());

        $selectedId      = $showoff->id;

        $productSimilarity = new ProductSimilarity($products);
        $similarityMatrix  = $productSimilarity->calculateSimilarityMatrix();
        $products          = $productSimilarity->getProductsSortedBySimularity($selectedId, $similarityMatrix);

        $similar =  array_slice($products, 0, 12);


        // Record History
        $this->HistoryController->store($showoff->id, $showoff->item_type, $showoff->user_id);

        return view('showoff.show', [
            'showoff' => $showoff,
            'similar' => $similar,
            'rates' => json_encode($this->CurrencyController->getCurrency())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShowOff  $showOff
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShowOff $showOff)
    {
       
        if($showOff->is_owner){
            $showOff->saves()->delete();
            $showOff->delete();
            return response("Success", 200);
        }else{
            return response("Unauthorized", 401);
        }
    }

    public function getList()
    {
        $productids = [];
        $total = collect([]);

        if (Auth::check()) {
            if (Auth::user()->pages) {
                $products = collect([]);

                // Get all the showffs and unused products find products
                $showoffIds = ShowOff::where('user_id', Auth::user()->id)->pluck('id');
                // return $showoffIds;
                $showoffProducts = ShowOffMeta::where('type', 'ProductList')
                    ->whereIn('show_off_id', $showoffIds)
                    ->pluck('link_id');
                // return $showoffProducts;

                $pages = Auth::user()->pages;

                if (count($pages) > 0) {
                    foreach ($pages as $page) {
                        $products = $products->concat($page->product->pluck('id'));
                    }
                }
                $productids = array_diff($products->toArray(), $showoffProducts->toArray());
            }
        }

        // Unused products ids
        $unused = array_values($productids);
        // return $unused;

        $remaininng = ProductMeta::whereIn('product_id', $unused)
            ->get();



        // by meta_id
        $order_by_meta_id = OrderProduct::where('user_id', Auth::user()->id)
            ->where('status', 'Delivered')
            ->pluck('products_meta_id');

        $ordered = ProductMeta::whereIn('id', $order_by_meta_id)
            ->get();

        $totalProductMetas = $ordered->concat($remaininng);

        $totalProductMetas = $totalProductMetas->unique('product.id');


        return PublicProductResource::collection($totalProductMetas);
    }
}
