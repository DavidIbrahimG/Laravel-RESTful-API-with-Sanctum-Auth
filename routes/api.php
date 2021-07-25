<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductControllerr;
use App\Http\Controllers\AuthController;


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


// PROTECTED ROUTES (WITH SANCTUM AUTH)
Route::group(['middleware' => 'auth:sanctum'], function () {
    
   
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('product/{id}', [ProductControllerr::class, 'store']);
    Route::put('product/{id}', [ProductControllerr::class, 'update']);
    Route::get('product/{id}', [ProductControllerr::class, 'destroy']);
    
});

// PUBLIC ROUTES WHICH CAN BE ACESSED WITHOUT TOKEN
// Route::apiResource('/product', ProductControllerr::class);
Route::get('product', [ProductControllerr::class, 'index']);
Route::get('product/{id}', [ProductControllerr::class, 'show']);
Route::get('product/search/{name}', [ProductControllerr::class, 'search']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);