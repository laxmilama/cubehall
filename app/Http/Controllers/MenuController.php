<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
class MenuController extends Controller
{
    public function index(){
        $section = Section::with('categories')->select('id', 'name', 'status')->get();
        // return $section->subcategories();
        return $section;
    }
}
