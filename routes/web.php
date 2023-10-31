<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function() {

    Route::group(['middleware'=>'admin.guest'], function(){
        Route::get('/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware'=>'admin.auth'], function(){
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        Route::get('/cateigories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/cateigories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/cateigories/list', [CategoryController::class, 'index'])->name('categories.list');


        Route::get('/getSlug', function(Request $request){
            $slug = "";
            if(!empty($request->title)) {
              $slug = Str::slug($request->title);
            }
            return response()->json([
               'status'=> true,
               'slug'=> $slug
            ]);
        })->name('getSlug');

    });


});