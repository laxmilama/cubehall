<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageCategory;
use App\Models\Page;
use App\Models\User;
use Auth;

class PageCategoryController extends Controller
{
    public function pageCategory()
    {
        $pageCategories = PageCategory::with(['studio'])->get();
        //dd($pageCategories);
        return view('pageCategory.page_category', ['pageCategories' => $pageCategories]);
    }

    public function index(){
        $page = Auth::user()->pages;
        $page_id = $page[0]['id'];
        return PageCategory::where('page_id', $page_id)->get();
    }

    public function addStudioCategory(Request $request)
    {
        $request->validate([
            'collection' => 'required|string',
        ]);

        $page = Auth::user()->pages;
        $page_id = $page[0]['id'];

        $coll = PageCategory::where('name', $request ->collection)
            ->where('page_id', $page_id)
            ->get();
        if(count($coll) > 0){
            return response('Already Exists', 429);
        }

        
        $pageCategory = new PageCategory;
        $pageCategory->name = $request ->collection;
        $pageCategory->page_id = $page_id;
        $pageCategory->status = 1;
        $pageCategory->save();

        return $pageCategory;
    }

    public function update(Request $request, PageCategory $pagecategory){
                
    }
    public function updateStatus(Request $request, PageCategory $pagecategory){
        $request->validate([
            'status'=>'numeric'
        ]);

        if($pagecategory->page_id == Auth::user()->pages[0]->id)
        {
            PageCategory::where('id', $pagecategory->id)->update(['status'=>$request->status]);

            return response('success', 200);
        }
        return response('Failed', 403);
    }

    public function destroy(PageCategory $pagecategory){

        if($pagecategory->page_id == Auth::user()->pages[0]->id)
        {
            $pagecategory->delete();

            return response('success', 200);
        }
        return response('Failed', 403);
    }
}
