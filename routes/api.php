<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('link')->group(function() {
    Route::get('/get/{unique_code}', [LinkController::class, 'getLink']);
    Route::get('/get-{key}', [LinkController::class, 'getByType']);
    Route::get('/search/{search}', [LinkController::class, 'search']);
    Route::post('/create', [LinkController::class, 'store']);
});
