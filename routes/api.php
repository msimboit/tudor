<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ScannersController;
use App\Http\Controllers\Api\ShiftsController;
use App\Http\Controllers\Api\IssuesController;
use App\Http\Controllers\ChatController;


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

Route::prefix('v1')->group(function() {
    Route::apiResource('/users', UsersController::class);

    Route::apiResource('/shifts', ShiftsController::class);
    Route::apiResource('/scans', ScannersController::class);
    Route::apiResource('/issues', IssuesController::class);
    Route::apiResource('/chats', ChatController::class);

});
