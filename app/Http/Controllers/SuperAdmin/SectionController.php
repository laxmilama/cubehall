<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Session;

class SectionController extends Controller
{
    public function sections(){
        $sections=Section::get();
        return view('superadmin.section.section')->with(compact('sections'));
    }
    public function addSection(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
           $section=new Section;
           $section->name=$data['name'];
            
           $section->status=1;
           $section->save();

           Session::flash('success_message','section has been added successfully!');
         return redirect('admin/sections');
   }
        return view('superadmin.section.add_section');
    }
}
