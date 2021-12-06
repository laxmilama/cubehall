<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\StoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', 'CategoryController@indexSection');
Route::get('categories/{id}', 'CategoryController@indexCategories');
Route::get('categories/{id}/sub', 'CategoryController@indexSubcategories');

//image upload
Route::post('post/thumbnail', 'ImageController@storeThumbnail');
Route::post('post/details', 'ImageController@multipleImages');

// Video Upload
Route::post('post/video', 'VideoController@store');

// Store Product
Route::post('post/list', 'ImageController@store');

// Stories
Route::post('post/story', 'StoryController@store');
Route::get('get/stories', 'StoryController@index');
Route::get('get/stories/{id}', 'StoryController@indexbyid');
Route::post('post/story/seen', 'StoryController@viewed');

Route::get('top/creators', 'ExploreController@topStudio');

// associate
Route::post('post/associate', 'AssociateController@store');

// Workings
Route::get('studio/sections', 'ProductSectionController@index');

// currency
Route::get('v1/exchangerates', 'CurrencyController@getCurrency');