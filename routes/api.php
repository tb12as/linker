<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
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

Route::post('/login', [AuthController::class, 'login'])->middleware('guest:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/get-user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('link')->group(function () {
        Route::get('/mine', [LinkController::class, 'myLinks']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('link')->group(function () {
    Route::get('/get/{unique_code}', [LinkController::class, 'getLink']);
    Route::get('/get-{key}', [LinkController::class, 'getByType']);
    Route::get('/search/{search}', [LinkController::class, 'search']);
    Route::post('/create', [LinkController::class, 'store'])->middleware('auth.conditional');
});
