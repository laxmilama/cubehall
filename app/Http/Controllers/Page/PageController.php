<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StudioAddressController;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Page;
use App\Models\User;
use App\Models\AdminPage;
use Auth;
use DB;
use Session;

class PageController extends Controller
{

  public function __construct(StudioAddressController $studioAddressController)
  {
    $this->StudioAddressController = $studioAddressController;
  }

  public function permissionDenied()
  {
    return view('page.nopermission');
  }

  public function createPage(Request $request)
  {
    if ($request->isMethod('post')) {
      if (Auth::check()) {
        if (Auth::user()->can('isPage')) {
          return response('Currently we only allow single studio per user', 403);
        }
      }
    }

    $role = Role::with(['permissions'])->where('slug', '=', 'admin')->firstOrFail();
    // $per = Permission::with(['roles' => function ($query) {
    //   $query->where('slug', '=', 'admin');
    // }])->get();
    $perr=$role->permissions;
    $per=[];
    foreach($perr as $permi){
      array_push($per,$permi->id);
    }
    //return $per;
    $da = Auth::user();
    // dd($role->id);
    //  $da = User::where('email', 'LIKE', $request->email.'%')->select('id')
    //  ->get();
    //  dd($da);
    // dd($per);
    // dd($per->roles()->slug); 
    // $permissions = Permission::with(['roles'=>function($query){
    //     $query->where('slug', '=', 'admin');
    // }])->get();
    //  dd($permissions);
    if ($request->isMethod('post')) {

      $page = new Page;
      $page->name = $request->name;
      $page->meta_description = $request->description;
      $page->slug = $request->handle;
      $page->status = 1;
      $page->save();

      // save address;
      $studio = $this->StudioAddressController->store($request->address, $page->id);


      //  $page->id = DB::getPdo()->lastinsertID();
      //  if($request->id != null){

      // $page->pages()->attach($page->id);
      //  }
      $user = auth()->user()->id;
      // dd($user);
      if (!empty(Auth::check())) {
        $user_id = Auth::user()->id;
        // dd($user);
        $page->users()->sync($user_id);
        $page->pageroles()->attach($role->id, ['user_id' => $user_id]);
        //  dd($page->ro());
        foreach($per as $p){
        $page->pagepermissions()->attach($p, ['user_id' => $user_id]);
        }
        // dd($page->roless()->attach($request->role));
        $page->save();
        return response('saved', 200);
      }
    }
    return view('page.pages');
  }
}
