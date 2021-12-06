<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use Session;
use Auth;

class CategoryController extends Controller
{
    public function categories(){
     
       if(!\Auth::guard('superadmin')->user()->hasRole('admin') && !\Auth::guard('superadmin')->user()->hasRole('manager')){
            $getCategory = Category::orderBy('id', 'desc')
            ->get();
          
        }else{
            $getCategory=Category::with(['sections','parentcategory'])->get();
        }
       // $getCategory=Category::with(['sections','parentcategory'])->get();
        
        return view('superadmin.category.categories')->with(compact('getCategory'));
    }
    public function addCategory(Request $request){
      
       // Auth::guard('superadmin')->user()->can('create', Category::class);
      // $this->authorize('create', \App\Models\Category::class);
     // $request->auth()->user()->can('create', $category);
        if($request->isMethod('post')){
            $data=$request->all();
            // dd($data);
           
            $request->validate([
                'section_id'=>'required',
                'name' => 'required',
                'meta_title' => 'required',
              
            ]);
            // dd($data);
            $user = auth()->guard('superadmin')->user();
           // dd($user);
           $category=new Category;
           $category->parent_id=$data['parent_id'];
           $category->section_id=$data['section_id'];
           $category->name=$data['name'];
           $category->discount=$data['discount'];
           $category->meta_title=$data['meta_title'];
           $category->superadmin_id=$user->id;
           $category->status=1;
           $category->save();

           Session::flash('success_message','category has been added successfully!');
         return redirect('admin/categories');
   }
        $getSection=Section::get();
        return view('superadmin.category.add_category')->with(compact('getSection'));
    }
    //append category level with ajax
    public function appendCategory(Request $request){
        if($request->ajax()){
            $data=$request->all();
            $getCategories=Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            $getCategories=json_decode(json_encode($getCategories),true);
            return view('superadmin.category.categories_level')->with(compact('getCategories'));
        }
    }
    public function editcategory(Request $request,Category $category){
        // $this->authorize('edit', $id);
        // if($request->isMethod('post')){
        //     $data=$request->all();
        //     Category::where('id',$id)->update(['name'=>$data['name']
        //     ,'parent_id'=>$data['parent_id'],'section_id'=>$data['section_id'],
        //     'discount'=>$data['discount']]);
        //     return redirect('/admin/categories');
      //  $this->authorize('edit', Category::class);
     
      $this->authorize('edit', $category);
    
        if($request->isMethod('post')){
            $data=$request->all();
            // dd($data);
           
            $request->validate([
                'section_id'=>'required',
                'name' => 'required',
                'meta_title' => 'required',
              
            ]);
            // dd($data);
            $user = auth()->guard('superadmin')->user();
           // dd($user);
          
           $category->parent_id=$data['parent_id'];
           $category->section_id=$data['section_id'];
           $category->name=$data['name'];
           $category->discount=$data['discount'];
           $category->meta_title=$data['meta_title'];
           $category->superadmin_id=$user->id;
           $category->status=1;
           $category->save();

           Session::flash('success_message','category has been added successfully!');
         return redirect('admin/categories');
   
}
    

    $getSection=Section::get();
   // $categoryDetails=Category::where(['id'=>$id])->first();
    $getCategories=Category::where(['parent_id'=>0,'section_id'=>$category['section_id']])->get();
           // dd($getCategories);
        return view('superadmin.category.edit_category')->with(compact('category','getSection','getCategories'));
    }

}
