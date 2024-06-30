<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegistryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
--------------------------------------------------------------------------
 API Routes
--------------------------------------------------------------------------

 Here is where you can register API routes for your application. These
 routes are loaded by the RouteServiceProvider within a group which
 is assigned the "api" middleware group. Enjoy building your API!

*/

Route::post('/register', [RegistryController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::group(['prefix' => 'post'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/', [PostController::class, 'store']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);
    });

});

