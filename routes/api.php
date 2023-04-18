<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => '/auth'], function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('/category', \App\Http\Controllers\Api\CategoryController::class)->except(['create', 'edit']);
    Route::resource('/product', \App\Http\Controllers\Api\ProductController::class)->except(['create', 'edit']);
    Route::resource('/order', \App\Http\Controllers\Api\OrderController::class)->except(['create', 'edit']);
    Route::get('/analytics', [\App\Http\Controllers\Analytics\AnalysisController::class, 'getTopSellingAndUnsoldProducts']);
});

