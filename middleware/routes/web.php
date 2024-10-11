<?php

use App\Http\Controllers\MiddlewareController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [MiddlewareController::class, 'login'])->name('login');
Route::get('logout', [MiddlewareController::class, 'logout'])->name('logout');
Route::post('login', [MiddlewareController::class, 'postLogin'])->name('postLogin');
Route::get('register', [MiddlewareController::class, 'register'])->name('register');
Route::post('register', [MiddlewareController::class, 'postRegister'])->name('postRegister');




Route::group([
    'prefix' => 'home',
    'as' => 'home.',
    'middleware' => 'checkSuperAdmin',
], function(){
    Route::get('home', [MiddlewareController::class, 'home'])->name('home');

    // password not 
    Route::get('forgot-password', [MiddlewareController::class, 'forgot'])->name('forgot');
    Route::get('resetPass/{token}', [MiddlewareController::class, 'resetPass'])->name('resetPass');
    Route::post('resetPass/{id}', [MiddlewareController::class, 'resetPostPass'])->name('resetPostPass');
    Route::post('forgot-password', [MiddlewareController::class, 'postForgot'])->name('postForgot');
});