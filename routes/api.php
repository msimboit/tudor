<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ScannersController;
use App\Http\Controllers\Api\ShiftsController;
use App\Http\Controllers\Api\IssuesController;
use App\Http\Controllers\Api\LeavesController;
use App\Http\Controllers\Api\QrCodeController;
use App\Http\Controllers\Api\VisitorLogController;
use App\Http\Controllers\Api\GeolocationController;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ShiftController;




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
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/panic', [IssuesController::class, 'panicAlert']);
        Route::get('/markers', [IssuesController::class, 'guardMarkers']);
    });

Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::apiResource('/users', UsersController::class);
    Route::apiResource('/shifts', ShiftsController::class);
    Route::apiResource('/scans', ScannersController::class);
    Route::apiResource('/issues', IssuesController::class);
    Route::post('/panicPost', [IssuesController::class, 'panic']);

    Route::apiResource('/chats', ChatController::class);
    Route::apiResource('/codes', QrCodeController::class);
    Route::apiResource('/leaves', LeavesController::class);

    Route::apiResource('/visitor-logs', VisitorLogController::class);

    Route::apiResource('/geolocation', GeolocationController::class);
    
    Route::post('/logout', [AuthController::class, 'logout']);
});