<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubcatController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ImageController;
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

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/addproducts',[ProductController::class,'addProducts']);
Route::get('/list',[ProductController::class,'list']);
Route::delete('/prodelete/{id}',[ProductController::class,'deleteProducts']);
Route::get('/productfind/{id}',[ProductController::class,'findProduct']);
Route::put('/productupdate/{id}',[ProductController::class,'updateProduct']);




Route::post('/addcat',[CategoriesController::class,'addCategory']);
Route::get('/allcat',[CategoriesController::class,'allCat']);
Route::get('/findcat/{id}',[CategoriesController::class,'findCategory']);
Route::put('/updatecat/{id}/{user_id}/{user_role}',[CategoriesController::class,'updateCategory']);
Route::delete('/deletecat/{id}/{user_id}/{user_role}',[CategoriesController::class,'deleteCategory']);
Route::put('/catstatuschange/{id}/{user_id}/{user_role}',[CategoriesController::class,'catStatusChange']);



Route::post('/addsubcat',[SubcatController::class,'addSubCategory']);
Route::get('/allsubcat',[SubcatController::class,'allSubCat']);
Route::get('/findsubcat/{id}',[SubcatController::class,'findSubCategory']);
Route::get('/findsubcatpro/{id}',[SubcatController::class,'findSubCategoryProduct']);
Route::put('/updatesubcat/{id}/{user_id}/{user_role}',[SubcatController::class,'updateSubCat']);
Route::put('/changesubcatstatus/{id}/{user_id}/{user_role}',[SubcatController::class,'changeSubCatStatus']);
Route::delete('/deletesubcat/{id}/{user_id}/{user_role}',[SubcatController::class,'deleteSubCat']);


Route::post('/addtag',[TagController::class,'addTag']);
Route::get('/alltags',[TagController::class,'allTag']);
Route::delete('/deletetag/{id}/{user_id}',[TagController::class,'deleteTag']);
Route::put('/change_status/{id}/{user_id}',[TagController::class,'changeStatus']);
Route::get('/findtag/{id}/{user_id}',[TagController::class,'findTag']);

Route::put('/updatetag/{id}/{user_id}',[TagController::class,'updateTag']);



Route::post('/addgallery',[GalleryController::class,'AddGallery']);




Route::post('/addimage',[ImageController::class,'AddImage']);