<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
//Userコントローラの宣言
use App\Http\Controllers\UserController;

//Restaurantコントローラの宣言
use App\Http\Controllers\Admin\RestaurantController;

//Categorieコントローラの宣言
use App\Http\Controllers\Admin\CategoryController;

//Companyコントローラの宣言
use App\Http\Controllers\Admin\CompanyController;

//Termコントローラの宣言
use App\Http\Controllers\Admin\TermController;

//Homeコントローラの宣言
use App\Http\Controllers\HomeController;


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

  //Home
  Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {

    // HOME
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');

    // User
    Route::resource('users', Admin\UserController::class)->only(['index', 'show']);

    //Restaunrant
    Route::resource('restaurants', Admin\RestaurantController::class);

    //Category
    Route::resource('categories', Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    //Company
    Route::resource('company', Admin\CompanyController::class)->only(['index', 'edit', 'update']);

    //Term
    Route::resource('terms', Admin\TermController::class)->only(['index', 'edit', 'update']);

});