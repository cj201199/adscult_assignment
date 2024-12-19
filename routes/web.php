<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::controller(AuthController::class)->group(function(){
    Route::get('login',  'index')->name('login');
    Route::post('post-login',  'postLogin')->name('login.post');
    Route::get('registration',  'registration')->name('register');
    Route::post('post-registration',  'postRegistration')->name('register.post');
    Route::get('dashboard',  'dashboard')->name('dashboard');
    Route::get('logout',  'logout')->name('logout');
});

Route::group(['middleware' => ['auth']],function(){

    Route::controller(ReviewController::class)->group(function(){
        Route::get('review-add','addReview')->name('review-add');
        Route::post('add-review',  'storeReview')->name('add-review');
        Route::get('review-edit/{id}','editReview')->name('review-edit');
        Route::post('update-review','updateReview')->name('update-review');
        Route::delete('review-delete-form/{id}','deleteReview')->name('review-delete-form');
    });

});
