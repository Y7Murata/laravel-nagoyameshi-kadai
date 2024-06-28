<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
//Userコントローラの宣言
use App\Http\Controllers\UserController;

//Restaurantコントローラの宣言
use App\Http\Controllers\Admin\RestaurantController;

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


require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {

    // HOME
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');

    // User
    Route::resource('users', Admin\UserController::class)->only(['index', 'show']);

    //　Restaunrantのルーティングを以下に１行でまとめて追加
    Route::resource('restaurants', Admin\RestaurantController::class);

});