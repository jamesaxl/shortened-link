<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\LinkController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('{locale}')->group(
    function () {
        Route::middleware('set.locale')->group(
            function () {
                Route::post('/login', [AuthController::class, 'login']);
                Route::post('/register', [AuthController::class, 'register']);
                Route::resource('/links', LinkController::class)->only(['show']);

                Route::middleware('auth:api')->group(
                    function () {
                        Route::resource('/links', LinkController::class)->except(['show']);
                        Route::post('/logout', [AuthController::class, 'logout']);
                    }
                );
            }
        );
    }
);
