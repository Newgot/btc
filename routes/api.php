<?php

use App\Http\Controllers\v1\BTC\GetController;
use App\Http\Controllers\v1\BTC\PostController;
use Illuminate\Http\Request;
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

Route::group([

], function () {
    Route::get('v1', GetController::class);
    Route::post('v1', PostController::class);
});
