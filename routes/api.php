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
    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware('auth:api');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('/category', \App\Http\Controllers\Api\Shop\CategoryController::class)->except(['create', 'edit']);

    Route::resource('/product', \App\Http\Controllers\Api\Shop\ProductController::class)->except(['create', 'edit']);
    Route::post('/product/upload/{product}', [\App\Http\Controllers\Api\Shop\ProductController::class, 'uploadImage']);
    Route::get('/product/upload/{product}', [\App\Http\Controllers\Api\Shop\ProductController::class, 'getImage']);
    Route::delete('/product/upload/{product}', [\App\Http\Controllers\Api\Shop\ProductController::class, 'deleteImage']);

    Route::resource('/order', \App\Http\Controllers\Api\Shop\OrderController::class)->except(['create', 'edit']);

    Route::group(['prefix' => '/analytics'], function () {
        Route::get('/get-top-sold-and-unsold', [\App\Http\Controllers\Api\Analytics\AnalysisController::class, 'getTopSoldAndUnsoldProducts']);
        Route::get('/get-expired-products', [\App\Http\Controllers\Api\Analytics\AnalysisController::class, 'getExpiredProducts']);
    });
});
