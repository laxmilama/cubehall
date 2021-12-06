<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use App\Models\Section;
use App\Models\Category;
use App\Models\ProductMeta;
use App\Models\Page;
use App\Models\ShowOffMeta;
use App\Models\ShowOff;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Response;
use Log;
use Input;
use App\Traits\HasRolesAndPermissions;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Resources\ProductResource;
use App\Models\History;
use App\Models\ShippingAddress;
use App\Models\SuperAdmin;
use App\Models\User;
use App\Notifications\ProductRequestNotification;
use Carbon\Carbon;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Http\Controllers\CurrencyController;

class ProductListController extends Controller
{
    use HasRolesAndPermissions;

    protected $HistoryController,  $ImageController;

    public function __construct(HistoryController $historyController, CurrencyController $currencyController, ImageController $imageController, ProductMetaController $productMetaController, ShippingAddressController $shippingAddressController)
    {
        $this->HistoryController = $historyController;
        $this->ImageController = $imageController;
        $this->ProductMetaController = $productMetaController;
        $this->ShippingAddressController = $shippingAddressController;
        $this->CurrencyController = $currencyController;
    }

    public function show(ProductList $product)
    {

        $list = ProductList::with(['metas' => function ($query) {
            // $query->groupBy("colorhex");
        }, 'tags' => function ($query) {
            $query->select(['show_off_id', 'link_id'])
                ->with(['showoff' => function ($query) {
                    $query->select(['id', 'title', 'slug', 'media']);
                }])->take(6);
        }, 'reviews' => function ($query) {
            $query->with(['writer'])
                ->take(4)->where('status', 1);
        }, 'owner' => function ($query) {
            // $query->select('id', 'slug', 'name');
        }])
            ->whereHas('metas')
            ->where('id', $product->id)
            ->firstOrFail();

        // return $list;

        // return ProductResource::collection(
        //     ProductList::where('id', $product->id)->get());

        // return $list->metas;
        $metas = collect($list->metas)->groupBy('colorhex');
        // return $metas;
        // $metas = collect([]);
        // foreach($list->metas as $meta){
        //     $m = ProductMeta::where('product_id', $meta->product_id)->where('colorhex', $meta->colorhex)->get();
        //     $metas = $metas->concat($m);

        // }
        // return $metas;

        // History for User
        $combined = collect([]);
        if (Auth::check()) {
            $histories = History::select('created_at', 'item_id', 'type')
                ->where('user_id', Auth::user()->id)
                ->where('type', 'App\Models\ProductList')
                ->groupBy('item_id', 'type', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->take(50)
                ->get();
        } else {

            if (Cookie::has('_uid')) {
                $uid = Cookie::get('_uid');
            } else {
                $now = Carbon::now();
                $rand = mt_rand(1000000, 9999999);
                $u = $now .  $rand;
                $uid = hash('sha256', $u);

                // set cookie
                Cookie::queue('_uid', $uid, 2628000);
            }
            $histories = History::select('created_at', 'item_id', 'type')
                ->where('session_id', $uid)
                ->where('type', 'App\Models\ProductList')
                ->groupBy('item_id', 'type', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->take(50)
                ->get();
        }
        // return $histories;

        $histories = $histories->unique('item_id');



        foreach ($histories as $history) {
            $lists = ProductList::with('meta')->where('id', $history->item_id)->get();
            $combined = $combined->concat($lists);
        }


        // products from similer categories
        $similer = ProductList::with(['metas' => function ($query) {
            // $query->groupBy("colorhex");
        }])
            ->whereHas('metas')
            ->where('category_id', $product->category_id)
            ->where('status', 1)
            ->where('id', '!=', $product->id)
            ->take(10)
            ->get();

        $this->HistoryController->store($product->id, $product->item_type, $product->page_id);

        return view('list', [
            'product' => $list,
            'metas' => $metas,
            'RecentlyViewedProducts' => $combined,
            'similarProducts' => $similer,
            'c' => json_encode($this->CurrencyController->getCurrency()) //currency
        ]);
    }

    public function products()
    {
        $products = ProductList::with(['category' => function ($query) {
            $query->select('id', 'name');
        }, 'section' => function ($query) {
            $query->select('id', 'name');
        }, 'attributes'])->get();
        //dd($products);
        // return $products;
        return view('page.products')->with(compact('products'));
    }

    public function studioProducts()
    {

        if (Gate::allows('isPage', Auth::user())) {
            $studio = Auth::user()->pages;

            // return $studio;
            $products = ProductList::where('page_id', $studio[0]->id)
                ->orderBy('created_at', 'desc')
                ->with(['category' => function ($query) {
                    $query->select('id', 'name');
                }, 'section' => function ($query) {
                    $query->select('id', 'name');
                }, 'meta'])
                ->get();

            //return $products;
            return view('page.products')->with(compact('products'));
        }
        return "Error occured";
    }

    public function lists($id)
    {
        $products = ProductList::where('page_id', $id)
            ->where('status', 1)
            ->with(['meta'])
            ->get();
        return ($products);
    }

    public function create()
    {

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        $productdata = array();
        // dd($productdata);
        return view('page.add_product', [
            'categories' => $categories,
            'productdata' => $productdata
        ]);
    }

    public function thumbUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
        ]);

        $filename = $this->ImageController->store($request->image->path(), true, 'product');
        if ($filename == 405) {
            return response('invalid aspected ratio', 405);
        }
        return response()->json(['image' => $filename]);
    }

    public function uploadDetails(Request $request)
    {
        $filename = $this->ImageController->multipleImages($request, false, 'product');

        if ($filename == 405) {
            return response('invalid aspected ratio', 405);
        }

        if (count($filename) == 1) {
            if ($filename[0] == 405) {
                return response('invalid aspected ratio', 405);
            }
        } else {
            if ($filename != null) {
                foreach ($filename as $key => $value) {
                    if ($filename[$key] == 405) {
                        unset($filename[$key]);
                    }
                }
                return response()->json(['images' => array_values($filename)]);
            }
        }

        return response()->json(['images' => $filename]);
    }



    public function addProduct(Request $request)
    {
        // return $request;
        $user = Auth::user();
        $user_id = $user->id;
        $page_id = $user->pages->first()->id;

        if ($request->commission == "true") {
            $commission = 1;
        } else {
            $commission = 0;
        }

        if ($request->customization == "true") {
            $customization = 1;
        } else {
            $customization = 0;
        }

        $product = new ProductList();
        $product->category_id = $request->category;
        $product->section_id = $request->secSelect;
        $product->user_id = $user_id;
        $product->page_id = $page_id;
        $product->name = $request->name;
        $product->slug = $request->name;
        $product->commission = $commission;
        $product->customization = $customization;
        $product->custom_message = $request->custommessage;
        $product->collection_id = $request->collection_id;
        $product->description = $request->description;
        $product->status = 0;
        $product->details = $request->technical;
        $product->save();

        $admins = SuperAdmin::get();
        // return $admins;
        $this->ProductMetaController->store($request->metas, $product->id, $product->page_id);

        // shipping address
        // $this->ShippingAddressController->store($request->shipping, $request->processing_time);
        $address = json_decode($request->shipping, true);


        for ($i = 0; $i < count($address); $i++) {
            //    return $address;
            $shipping = new ShippingAddress();

            $shipping->page_id = $page_id;
            $shipping->min_days = $address[$i]['delivery_time'];
            $shipping->max_days = $address[$i]['delivery_time'];
            $shipping->primary = $address[$i]['primary_cost'];
            $shipping->additional = $address[$i]['secondary_cost'];
            $shipping->city = $address[$i]['city'];
            $shipping->country = $address[$i]['country_name'];
            $shipping->save();
            $product->shipping()->attach($shipping->id);
            $product->save();
        }



        foreach ($admins as $admin) {
            // return $followtoss;

            $admin->notify(new ProductRequestNotification($product));
        }



        return $product->slug;
    }

    public function edit(ProductList $product)
    {
        $list = ProductList::with(['metas' => function ($query) {
            // $query->groupBy("colorhex");
        }, 'tags' => function ($query) {
            $query->select(['show_off_id', 'link_id'])
                ->with(['showoff' => function ($query) {
                    $query->select(['id', 'title', 'slug', 'media']);
                }])->take(6);
        }, 'reviews' => function ($query) {
            $query->take(4)->where('status', 1);
        }])
            ->whereHas('metas')
            ->where('id', $product->id)
            ->firstOrFail();

        return view('product.edit', [
            'product' => $list,
        ]);
    }


    public function destroy($product_id, $studioid)
    {
        // return true;
        // return $studioid;
        $product = ProductList::find($product_id);


        // validate request
        if (is_numeric($product_id) && is_numeric($studioid)) {
            //  check user has permition for the action
            if ($this->authorize('delete', $product)) {
                // delete product if has delete permission

                $product->saves()->delete();
                $deleted = ProductList::where('id', $product_id)
                    ->where('page_id', $studioid)
                    ->delete();
                if ($deleted) {
                    return response('success', 200);
                } else {
                    return response('failed', 406);
                }
            } else {
                return response('Permission Not Granted', 403);
            }
        } else {
            return response("invalid request", 400);
        }
    }
}
