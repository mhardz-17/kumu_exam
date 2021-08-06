<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('github/users/{users_name?}',[\App\Http\Controllers\Api\GithubController::class,'users']);
Route::get('sanctum-login',[\App\Http\Controllers\Auth\LoginController::class,'sanctumLogin']);
Route::middleware('auth:sanctum')->get('sanctum-logout',[\App\Http\Controllers\Auth\LoginController::class,'sanctumLogout']);
