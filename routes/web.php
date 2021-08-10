<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['notlogin']], function(){

 Route::get('/confirm', [App\Http\Controllers\Auth\VerificationController::class, 'index'])->name('confirm');

 Route::get('/', function () {
     return view('welcome');
 });
});


Auth::routes();
Route::group(['namespace' => 'User','middleware'=>['user']], function(){
 Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
});

Route::group(['prefix' => 'admin','namespace' => 'Admin','as'=>'admin.','middleware'=>['admin']], function(){
 Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
});