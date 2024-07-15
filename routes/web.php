<?php

use Illuminate\Support\Facades\Route;

//①
use App\Http\Controllers\Admin;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;

//②
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\Subscribed;
//②
use App\Http\Middleware\NotSubscribed;

use App\Http\Controllers\ReviewController;

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

    //Restaurant
    Route::resource('restaurants', RestaurantController::class)->only(['index','show']);

    //User
    Route::group(['middleware' => ['auth', 'verified']], function () {
      Route::resource('user', UserController::class)->only(['index', 'edit', 'update']);

      Route::resource('restaurants.reviews', ReviewController::class)->only(['index']);

    //一般ユーザとしてログイン済かつメール認証済で有料プラン未登録の場合
      Route::group(['middleware' => [NotSubscribed::class]], function () {
          Route::get('subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
          Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
      });
    //一般ユーザとしてログイン済かつメール認証済で有料プラン登録済の場合
      Route::group(['middleware' => [Subscribed::class]], function () {
          Route::get('subscription/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
          Route::patch('subscription', [SubscriptionController::class, 'update'])->name('subscription.update');
          Route::get('subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
          Route::delete('subscription', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');
      
          Route::resource('restaurants.reviews', ReviewController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        });
      });
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