<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResources;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\ProductList;

class CategoryController extends Controller
{

    public function indexSection()
    {
        $section = Section::all('id', 'name');
        return $section;
    }

    public function indexCategories($id)
    {
        $categories = Category::where('section_id', $id)
            ->where('parent_id', '=', 0)
            ->get(['id', 'name', 'slug']);
        return $categories;
    }

    public function indexSubcategories($id)
    {
        $sub = Category::where('parent_id', $id)
            ->where('parent_id', '>', 0)
            ->whereHas('product')
            ->with('product')
            ->get(['id', 'name', 'slug']);
        return CategoryResources::collection($sub);
    }


    public function showPrimary(Category $category)
    {
        // $subcategory = $this->indexSubcategories($category->id);

        // return $subcategory;
        return view('category.primary', [
            'catId' => $category->id,
            'primary' => $category,
        ]);

    }

    public function all(){
        $sections = Section::with(['categories' => function ($query) {
            $query->with(['subcategories' => function ($q) {
                $q->whereHas('product');
            }]);

            $query->whereHas('subcategories', function ($q) {
                $q->whereHas('product');
            });
        }])
            ->whereHas('categories', function ($query) {
                    $query->whereHas('subcategories', function($p){
                        $p->whereHas('product');
                    });
            })
            ->get();
            return view('category.all', [
                'sections' => $sections,
            ]);
    }

    public function primary(Category $category, Request $request)
    {
        $subcategory = $this->indexSubcategories($category->id);

        $subIDs = $subcategory->pluck('id');

        // return $subIDs;

        // Find Products based on sub Ids.
        // $products = ProductList::whereIn('category_id', $subIDs)->where('status', '1')->with(['owner', 'meta'])->latest()->get();

        $products = ProductList::query();

        if ($request->get('size')) {

            $products = $products
                ->whereIn('category_id', $subIDs)
                ->with('meta')
                ->whereHas('meta', function ($query) {
                    $query->where('size', $_GET['size']);
                })
                ->where(['status' => 1]);
        }

        if ($request->get('material')) {
            $products = $products
                ->whereIn('category_id', $subIDs)
                ->with('meta')
                ->whereHas('meta', function ($query) {

                    $materials = explode(',', $_GET['material']);
                    $query->where( function ($q) use($materials){                        
                        for ($i = 0; $i < count($materials); $i++){
                            $q->orwhere('material', 'LIKE',  '%' . $materials[$i] .'%');
                         }
                    });
                })
                ->where(['status' => 1]);
        }

        if ($request->get('color')) {
            $products = $products
                ->whereIn('category_id', $subIDs)
                ->with(['meta' => function ($query){
                    $query->where('colors', 'LIKE', '%'. $_GET['color'] . '%');
                }])
                ->whereHas('meta', function($query){
                    $query->where('colors', 'LIKE', '%'. $_GET['color'] . '%');
                })
                ->where(['status' => 1]);
        }


        if (count($request->all()) == 0) {
            $products = $products
                ->where('status', '1')
                ->with('meta')
                ->whereIn('category_id', $subIDs)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $products = $products
                ->where('status', '1')
                ->with('meta')
                ->orderBy('created_at', 'desc')
                ->get();
        }


        // return view('category.primary', [
        //     'subcategory' => $subcategory,
        //     'primary' => $category,
        //     'products' => $products,
        // ]);
        return $products->paginate(12);
    }

    public function showSecondary(Category $category, Category $subcategory)
    {
        return view('category.secondary', [
            'category' => $subcategory,
            // 'products' => $products,
        ]);
    }

    public function secondary(Category $category, Category $subcategory,  Request $request)
    {
        

        $subIDs = $subcategory->id;

        // Find Products based on sub Ids.
        // $products = ProductList::whereIn('category_id', $subIDs)->where('status', '1')->with(['owner', 'meta'])->latest()->get();

        $products = ProductList::query();

        if ($request->get('size')) {

            $products = $products
                ->where('category_id', $subIDs)
                ->with('meta')
                ->whereHas('meta', function ($query) {
                    $query->where('size', $_GET['size']);
                })
                ->where(['status' => 1]);
        }

        if ($request->get('material')) {
            $products = $products
                ->where('category_id', $subIDs)
                ->with('meta')
                ->whereHas('meta', function ($query) {

                    $materials = explode(',', $_GET['material']);
                    $query->where( function ($q) use($materials){                        
                        for ($i = 0; $i < count($materials); $i++){
                            $q->orwhere('material', 'LIKE',  '%' . $materials[$i] .'%');
                         }
                    });
                })
                ->where(['status' => 1]);
        }

        if ($request->get('color')) {
            $products = $products
                ->where('category_id', $subIDs)
                ->with(['meta' => function ($query){
                    $query->where('colors', 'LIKE', '%'. $_GET['color'] . '%');
                }])
                ->whereHas('meta', function($query){
                    $query->where('colors', 'LIKE', '%'. $_GET['color'] . '%');
                })
                ->where(['status' => 1]);
        }


        if (count($request->all()) == 0) {
            $products = $products
                ->where('status', '1')
                ->with('meta')
                ->where('category_id', $subIDs)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $products = $products
                ->where('status', '1')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $products->paginate(12);
    }
}
