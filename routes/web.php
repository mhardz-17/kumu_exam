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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('hamming-distance', [App\Http\Controllers\HammingDistanceController::class, 'index']);
    Route::post('hamming-distance', [App\Http\Controllers\HammingDistanceController::class, 'compute']);

    Route::get('github-user-tester',[\App\Http\Controllers\GithubUserTesterController::class,'index']);
});
