<?php

use App\Models\Link;
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
Route::get('r/{code}', function ($uniqueCode) {
    $link = Link::where('unique_code', $uniqueCode)->first();
    if ($link != null) {
        // for every view add 30 minutes to expire date
        $link->expire_at = $link->expire_at->addMinutes(30);
        $link->views_count += 1;
        $link->save();

        return redirect($link->original_link);
    }

    abort(404);
})->name('red');

Route::get('/', function () {
    return view('welcome');
});
