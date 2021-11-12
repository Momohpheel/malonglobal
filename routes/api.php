<?php

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

Route::prefix('user')->group(function () {
    Route::get('jobs', [App\Http\Controllers\UserController::class, 'getAllJobs']);
    Route::get('jobs/{id}', [App\Http\Controllers\UserController::class, 'getJob']);
    Route::post('jobs/{id}/apply', [App\Http\Controllers\UserController::class, 'apply']);
    Route::post('search', [App\Http\Controllers\UserController::class, 'search']);
});

Route::prefix('business')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [App\Http\Controllers\BusinessController::class, 'login']);
        Route::post('register', [App\Http\Controllers\BusinessController::class, 'signup']);
    });
    Route::middleware(['auth:api'])->group(function () {
        Route::post('job/create', [App\Http\Controllers\BusinessController::class, 'addJob']);
        Route::patch('job/update/{id}', [App\Http\Controllers\BusinessController::class, 'updateJob']);
        Route::delete('job/delete/{id}', [App\Http\Controllers\BusinessController::class, 'removeJob']);
        Route::get('jobs/all', [App\Http\Controllers\BusinessController::class, 'getAllJobs']);
        Route::get('job/{id}', [App\Http\Controllers\BusinessController::class, 'getJob']);
    });

});
